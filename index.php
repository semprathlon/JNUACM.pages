<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jiangnan University ACM-ICPC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1">
    <link rel="stylesheet" href="./assets/forum.css">
    <script src="./js/main.js"></script>
    <?php
    require_once "header.php";
    ?>
    <script type="text/javascript">
        function go(param){
//            alert('then'+param);
                if (param.match(/login$/)){
                    load_login_panel();
                    param.replace(/login$/,'');
                }
                if (param.match(/signup$/)){
                    load_signup_panel();
                    param.replace(/signup$/,'');
                }
                if (param.match(/p=\d+$/)) {
//                    display_loading();
                    loadSinglePost(param.match(/p=(\d+)$/)[1]);
                    return;
                }
                if (param.match(/print$/)){
//                    display_loading();
                    loadPrint();
                    return;
                }
                if (param.match(/profile$/)){
                    loadProfilePage();
                    return;
                }
                if (param.match(/settings$/)){
                    loadSettingPage();
                    return;
                }
                if (param===''||param.match(/index$/)||param.match(/all$/)||param.match(/t=\w+$/)){
//                    display_loading();
                    loadMainPage();
                    return;
                }
        };
        function routing(){
            var param=window.location.search;
            
            var promise=new Promise(function(resolve){
                if (loadControls()){
                    alert('init');
                    resolve(param);
                    
                }
                
            });
            
            promise.then(go(param));
            
            
        }
        var fsm=StateMachine.create({
//            initial:'main',
            events:[
                {name:'load-main',from:'none',to:'main'},
            ]
        })
    </script>
    <script type="text/javascript">
        function loadProfilePage(){
            $.get('user_profile.php', function (returnData) {
                $('#content').html(returnData);
            })
        }
        function loadSettingPage(){
            $.get('user_settings.php', function (returnData) {
                $('#content').html(returnData);
            })
        }
        function load_login_panel(){
        $.ajax({
            url: 'login_panel.php',
            cache: false,
            success: function (returnData) {
                $('#model-manager').html(returnData);
                _oTag = document.getElementById("model-manager");
                _oTag.style.display = "block"; // reveal it.
                _oTag = document.getElementById("model");
                _oTag.style.display = ""; // reveal it.
            }
        });
    }
    function load_signup_panel() {
        $.ajax({
            url: 'signup_panel.php',
            cache: false,
            success: function (returnData) {
                $('#model-manager').html(returnData);
                _oTag = document.getElementById("model-manager");
                _oTag.style.display = "block"; // reveal it.
                _oTag = document.getElementById("model");
                _oTag.style.display = ""; // reveal it.
            }
        });
    }
        function loadControls() {
            $.get('user_verify.php', function (res) {
                if (res.result) {
                    $.get('user_controls.php', function (returnData) {
                        $('#header-secondary').html(returnData);
                    });
                }
                else {
                    $.get('anonymous_controls.php', function (returnData) {
                        $('#header-secondary').html(returnData);
                    });
                }
                return true;
            });
            return false;
        }
        function loadMainPage() {
//            window.location.search="";
            $.ajax({
                url: 'main.php',
                cache: false,
                success: function (returnData) {
                    $('#content').html(returnData);

                    /*$('.item-read-more').each(function () {
                     $(this).click(function (evt) {
                     evt.preventDefault();
                     //                            alert($(this).attr('id'));
                     loadSinglePost($(this).attr('id'));
                     })
                     })*/
                }
            });
        }
        function loadSinglePost(pid) {
            //xmlhttpload_get("single.php?p=" + pid, "content");
//            window.location.search='single.php?p=' + pid;
            $.ajax({
                url: 'single.php?p=' + pid,
                cache: false,
                success: function (returnData) {
                    $('#content').html(returnData);
                }
            });
        }
        function loadTaglist(tid) {
            deactivate_all();
            activate($('.item-tag'+tid));
            setTimeout(function () {
            $.get('taglist.php?tid=' +tid, function (returnData) {
                $('[id=IndexPage-list]').html(returnData);
            });
           }, 500);
        }
        function loadPrint(){
//            window.location.search="print";
            $.ajax({
                url: 'print.php',
                cache: false,
                success: function (returnData) {
                    $('#content').html(returnData);
                }
            });
        }
        function display_loading() {
            $.get('loading.html', function (returnData) {
                $('#content').html(returnData);
            })
            // .... 其他指令
            /*_oTag = document.getElementById("model");
             _oTag.style.display = "none"; // hide it.
             _oTag = document.getElementById("modal-loading");
             _oTag.style.display = "none"; // hide it.*/
        }
        $(document).ready(function () {
            /*if (window.attachEvent) {
             window.attachEvent('onload', display_loading);
             } else {
             window.addEventListener('load', display_loading, false);
             }*/
            $('#home-link').click(function (evt) {
                evt.preventDefault();
                history.pushState(null,'','?index');
                loadMainPage();
            })
            $('#print-link').click(function (evt) {
                evt.preventDefault();
                history.pushState(null,'','?print');
                loadPrint();
            })
        });
        $(document).scroll(function () {
            if ($(this).scrollTop()>0)
                set_on($('[id=app]'),'class',' scrolled');
            else
                set_off($('[id=app]'),'class',' scrolled',/ scrolled/g);
        })
        window.addEventListener('popstate', function(evt){
            var state = evt.state;
            location.reload();
        }, false);
    </script>
</head>
<body>
<script>
    routing();
</script>
<div id="app" class="App App--index affix">
    <div id="app-navigation" class="App-navigation">
        <div class="Navigation ButtonGroup App-backControl">
            <button class="Button Button--icon Navigation-drawer hasIcon" type="button"><i
                    class="icon fa fa-fw fa-reorder Button-icon"></i></button>
        </div>
    </div>
    <div id="drawer" class="App-drawer">
        <header id="header" class="App-header">
            <div id="header-navigation" class="Header-navigation">
                <div class="Navigation ButtonGroup "></div>
            </div>
            <div class="container">
                <h1 class="Header-title">
                    <a id="home-link">
                        JNU-ACM Club::Home
                    </a>
                </h1>
                <h1 class="Header-title">
                    <a href="/swap/" id="home-link">
                        Swap
                    </a>
                </h1>
                <h1 class="Header-title">
                    <a id="print-link">
                        PrintService
                    </a>
                </h1>
                <div id="header-primary" class="Header-primary">
                    <ul class="Header-controls"></ul>
                </div>
                <div id="header-secondary" class="Header-secondary">
                </div>
            </div>
        </header>
    </div>

    <main class="App-content">
        <div id="content">
            <?php
            include 'loading.html';
            ?>
        </div>
    </main>

    <br style="clear: both;">
    <?php
    include_once "footer.php"
    ?>
</div>
<div id="model" style="display: none;">
    <div class="ModalManager modal fade in"
         style="display: block;position: fixed;top: 0;right: 0;bottom: 0;left: 0;overflow: hidden;background-color: rgba(170, 170, 170, 0.901961);">
        <div id="model-manager">
            <?php
            include 'loading.html';
        ?>
        </div>
    </div>
</div>
</body>
</html>