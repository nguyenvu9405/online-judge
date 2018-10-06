<div class="panel card">
    <div class="header-container">
        <div class="title">
            <span>Tags</span>
        </div>
    </div>
    <div class="body-container">
        <div class="tag-box">
        <?php
            $tags = Problem::selectTags("problem_id=?",array($prob->getId()));
            if ($tags)
            {
                foreach ($tags as $tag)
                {
                    echo "<div class='tag non-deletable-tag'>
                                <span>{$tag['tag']}</span>
                          </div>";
                }
            }
        ?>
        </div>
    </div>
</div>