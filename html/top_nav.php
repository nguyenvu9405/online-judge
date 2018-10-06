<div id="scrim">

</div>

<div class="side-nav" id="left-side-nav">
    <ul>
        <li class="ver-list-item">
            <a class="link-condensed" href="/index.php">
                <i class="material-icons">home</i>
                <span class="condensed">home</span>
            </a>
        </li>
        <li class="ver-list-item">
            <a class="link-condensed" href="/problems.php">
                <i class="material-icons">view_list</i>
                <span class="condensed">problems</span>
            </a>
        </li>
        <li class="ver-list-item">
            <a class="link-condensed" href="/status.php">
                <i class="material-icons">insert_chart</i>
                <span class="condensed">status</span>
            </a>
        </li>
        <li class="ver-list-item">
            <a class="link-condensed" href="/status.php">
                <i class="material-icons">live_help</i>
                <span class="condensed">Help</span>
            </a>
        </li>
    </ul>

</div>

<div id="top_nav">

    <ul>

        <li id="hambuger">
            <button class="nav-button nav-button-icon">
                <i class="material-icons">menu</i>
            </button>
        </li>

        <li class="nav-logo">
            <a href="/index.php">
                <i class="fa fa-keyboard-o" aria-hidden="true"></i>
                Coders
            </a>
        </li>

        <li class="nav-menu-container" id="nav-left">
            <ul class="nav-menu">
                <li>
                    <a class="nav-button nav-button-text" href="/index.php">HOME</a>
                </li>
                <li>
                    <a class="nav-button nav-button-text" href="/problems">PROBLEMS</a>
                </li>
                <li>
                    <a class="nav-button nav-button-text" href="/status.php">STATUS</a>
                </li>
                <li class="dropdown hover-container">
                    <a class="nav-button nav-button-text" href="/index.php">HELP</a>
                    <div class="dropdown-container vertical-list-container">
                        <ul>
                            <li class="ver-list-item">
                                <a href="/index.php">
                                    <i class="material-icons">school</i>
                                    <span>Teacher guide</span>
                                </a>
                            </li>
                            <li class="ver-list-item">
                                <a href="/index.php">
                                    <i class="material-icons">face</i>
                                    <span>Student guide</span>
                                </a>
                            </li>
                            <li class="ver-list-item">
                                <a href="/index.php">
                                    <i class="material-icons">live_help</i>
                                    <span>Contact us</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        <li class="nav-menu-container" id="nav-right">
            <ul class="nav-menu">
                <li class="dropdown">
                    <button class="nav-button nav-button-icon" id="user-button">
                        <i class="material-icons">account_circle</i>
                    </button>
                    <?php
                    if ($cuser)
                    {
                        include "user_control_dropdown.php";
                    }
                    else
                    {
                        include "login_dropdown.php";
                    }
                    ?>
                </li>
            </ul>
        </li>
        <div class="clear-fix"></div>
    </ul>
</div>