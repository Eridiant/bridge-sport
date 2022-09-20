            <?= $this->render('_messages', compact('model', 'wrapper')); ?>
            <div class="messages-form hide">
                <p class="messages-reply"></p>
                <div class="messages-textarea" contentEditable></div>
                <div class="messages-btn">
                    <svg width="36" height="36"><use xlink:href="/images/icons.svg#button-arrow"></use></svg>
                </div>
                <p class="messages-errors"></p>
            </div>