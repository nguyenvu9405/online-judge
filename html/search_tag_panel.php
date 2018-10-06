<div class="card panel">
    <div class="header-container">
        <div class="title">
            <span>Search</span>
        </div>
    </div>
    <div class="body-container input-field">
        <div class="label">
            <label for="tag-input">Tags</label>
        </div>
        <form  class="tag-form" action="" method="get" id="tag-form" class="search-tag-form" >
            <input id="tag-values" name="tags" type="hidden">
            <div id="tag-box" class="tag-box input-border-bot">
                <input type="search" id="tag-input" class="tag-input" list="tag-options">
                <datalist id="tag-options">
                </datalist>
            </div>
        </form>
    </div>
    <div class="footer-container">
        <input type="submit" class="raise-button" value="search" form="tag-form">
    </div>
</div>