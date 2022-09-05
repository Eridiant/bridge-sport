<?php

namespace common\rbac;

use Yii;
use yii\base\InvalidArgumentException;
use yii\base\InvalidCallException;
use yii\caching\CacheInterface;
use yii\rbac\PhpManager;
use common\models\AuthAssignment as Assignment;
use yii\db\Connection;
use yii\db\Expression;
use yii\db\Query;
use yii\di\Instance;

class AuManager extends PhpManager
{
    public $cache;

    public $db = 'db';

    public $assignmentTable = '{{%auth_assignment}}';

    /**
     * @var string the path of the PHP script that contains the authorization items.
     * This can be either a file path or a [path alias](guide:concept-aliases) to the file.
     * Make sure this file is writable by the Web server process if the authorization needs to be changed online.
     * @see loadFromFile()
     * @see saveToFile()
     */
    public $itemFile = '@common/rbac/items.php';
    /**
     * @var string the path of the PHP script that contains the authorization assignments.
     * This can be either a file path or a [path alias](guide:concept-aliases) to the file.
     * Make sure this file is writable by the Web server process if the authorization needs to be changed online.
     * @see loadFromFile()
     * @see saveToFile()
     */
    public $assignmentFile = '@common/rbac/assignments.php';
    /**
     * @var string the path of the PHP script that contains the authorization rules.
     * This can be either a file path or a [path alias](guide:concept-aliases) to the file.
     * Make sure this file is writable by the Web server process if the authorization needs to be changed online.
     * @see loadFromFile()
     * @see saveToFile()
     */
    public $ruleFile = '@common/rbac/rules.php';

    /**
     * @var array user assignments (user id => Assignment[])
     * @since `protected` since 2.0.38
     */
    protected $checkAccessAssignments = [];

    /**
     * Initializes the application component.
     * This method overrides the parent implementation by establishing the database connection.
     */
    public function init()
    {
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::className());
        if ($this->cache !== null) {
            $this->cache = Instance::ensure($this->cache, 'yii\caching\CacheInterface');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAssignments($userId)
    {
        if ($this->isEmptyUserId($userId)) {
            return [];
        }

        $query = (new Query())
            ->from($this->assignmentTable)
            ->where(['user_id' => (string) $userId]);

        $assignments = [];
        foreach ($query->all($this->db) as $row) {
            $assignments[$row['item_name']] = new Assignment([
                'user_id' => $row['user_id'],
                'item_name' => $row['item_name'],
                'created_at' => $row['created_at'],
            ]);
        }

        return $assignments;
        // if ($userId && $user = $this->getUser($userId)) {
        //     $assignment = new Assignment();
        //     $assignment->user_id = $userId;
        //     $assignment->item_name = $user->role;
        //     return [$assignment->item_name => $assignment];
        // }
        // return [];
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAssignment($roleName, $userId)
    {
        if ($this->isEmptyUserId($userId)) {
            return null;
        }

        $row = (new Query())->from($this->assignmentTable)
            ->where(['user_id' => (string) $userId, 'item_name' => $roleName])
            ->one($this->db);

        if ($row === false) {
            return null;
        }

        return new Assignment([
            'user_id' => $row['user_id'],
            'item_name' => $row['item_name'],
            'created_at' => $row['created_at'],
        ]);
        // if ($userId && $user = $this->getUser($userId)) {
        //     if ($user->role == $roleName) {
        //         $assignment = new Assignment();
        //         $assignment->user_id = $userId;
        //         $assignment->item_name = $user->role;
        //         return $assignment;
        //     }
        // }
        // return null;
    }

    /**
     * {@inheritdoc}
     * The roles returned by this method include the roles assigned via [[$defaultRoles]].
     */
    // public function getRolesByUser($userId)
    // {
    //     if ($this->isEmptyUserId($userId)) {
    //         return [];
    //     }

    //     $query = (new Query())->select('b.*')
    //         ->from(['a' => $this->assignmentTable, 'b' => $this->itemTable])
    //         ->where('{{a}}.[[item_name]]={{b}}.[[name]]')
    //         ->andWhere(['a.user_id' => (string) $userId])
    //         ->andWhere(['b.type' => Item::TYPE_ROLE]);

    //     $roles = $this->getDefaultRoleInstances();
    //     foreach ($query->all($this->db) as $row) {
    //         $roles[$row['name']] = $this->populateItem($row);
    //     }

    //     return $roles;
    // }

    /**
     * {@inheritdoc}
     */
    public function assign($role, $userId)
    {
        $assignment = Assignment::find()
            ->where('user_id=:user_id')
            ->addParams([':user_id' => $userId])
            ->one();

        if ($assignment) {
            $assignment->item_name = $role->name;
            $assignment->save();
            unset($this->checkAccessAssignments[(string) $userId]);
            return $assignment;
        }

        $assignment = new Assignment([
            'user_id' => $userId,
            'item_name' => $role->name,
            'created_at' => time(),
        ]);

        $this->db->createCommand()
            ->insert($this->assignmentTable, [
                'user_id' => $assignment->user_id,
                'item_name' => $assignment->item_name,
                'created_at' => $assignment->created_at,
            ])->execute();
        
        unset($this->checkAccessAssignments[(string) $userId]);
        return $assignment;

        // if ($userId && $user = $this->getUser($userId)) {
        //     var_dump('<pre>');
        //     var_dump($user->authAssignments);
        //     var_dump('</pre>');
        //     die;
            
        //     $this->setRole($user, $role->name);
        // }
    }


    /**
     * {@inheritdoc}
     */
    public function revoke($role, $userId)
    {
        if ($this->isEmptyUserId($userId)) {
            return false;
        }

        unset($this->checkAccessAssignments[(string) $userId]);
        return $this->db->createCommand()
            ->delete($this->assignmentTable, ['user_id' => (string) $userId, 'item_name' => $role->name])
            ->execute() > 0;
    }

    /**
     * {@inheritdoc}
     */
    public function revokeAll($userId)
    {
        if ($this->isEmptyUserId($userId)) {
            return false;
        }

        unset($this->checkAccessAssignments[(string) $userId]);
        return $this->db->createCommand()
            ->delete($this->assignmentTable, ['user_id' => (string) $userId])
            ->execute() > 0;
    }

    /**
     * {@inheritdoc}
     */
    public function removeAllAssignments()
    {
        $this->checkAccessAssignments = [];
        $this->db->createCommand()->delete($this->assignmentTable)->execute();
    }

    /**
     * Check whether $userId is empty.
     * @param mixed $userId
     * @return bool
     * @since 2.0.26
     */
    protected function isEmptyUserId($userId)
    {
        return !isset($userId) || $userId === '';
    }

    public function getUser($userId)
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->id == $userId) {
            return Yii::$app->user->identity;
        } else {
            return User::findOne($userId);
        }
    }

    public function setRole($user, $roleName)
    {
        // $user->role = $roleName;
        $user->updateAttrs(['role' => $roleName]);
    }
}