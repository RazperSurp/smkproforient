<body>
    <header>
        <div class="wrapper">
            <a id="header-logo--wrapper" href="/">
                <img src="/assets/img/logo.svg" width="75" height="75">
                <div>
                    <h5> Ставропольский многопрофильный колледж </h5>
                    <h2> Профориентация </h2>
                </div>
            </a>
            <nav>
                <ul>
                    <?php foreach ($this->_app->getParam('header-nav') as $name => $data): ?>
                        <?php if(!isset($data['show']) || $data['show']): ?> 
                            <?php if ($data['children']): ?>
                                <li>
                                    <button rh-cmpnt="dropdown" aria-state="false" aria-group="nav-list-dropdown" aria-controls="show" aria-target="#nav-list-<?= $name ?>"> <?= $data['title'] ?> </button>
                                    <ul class="nav-list-dropdown" id="nav-list-<?= $name ?>">
                                        <?php foreach ($data['children'] as $script => $subdata): ?>
                                            <?php if(!isset($subdata['show']) || $subdata['show']): ?> 
                                                <li> <a href="/<?= $name ?>/<?= $script ?>"> <?= $subdata['title'] ?> </a> </li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php else: ?>
                                <li> <a href="/site/<?= $name ?>"> <?= $data['title'] ?> </button> </li>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div id="<?= ($this->exception ? 'exception' : $this->_app->request->router .'-'. $this->_app->request->script) ?>-view">
            <?php 
                if ($this->exception) require($this->_theme .'/service/exception/index.php');
                else require($this->_theme .'views/'. $this->_app->request->router .'/'. $this->_app->request->script .'.php');
            ?>
        </div>
    </main>
    <footer>
        <div class="wrapper">
            somefooter
        </div>
    </footer>
</body>
<?php foreach ($this->_jsFiles['after'] as $link): ?>
    <?php if(str_ends_with($link, '.mjs')): ?>
        <script type="module" src="/assets/js/<?= $link ?>"> </script>
    <?php else: ?>
        <script type="text/javascript" src="/assets/js/<?= $link ?>"> </script>
    <?php endif; ?>
<?php endforeach; ?>
</html>