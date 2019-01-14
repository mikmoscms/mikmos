<!DOCTYPE html>
<html lang="<?php _e($_LANG);?>">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?php _e(__WEBDESC);?>">
<meta name="author" content="<?php _e(__CMS);?>">
<link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
<title><?php _e(__WEBTITLLE);?></title>
<link href="assets/css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/helper.css" rel="stylesheet">
<?php if(empty($_SESSION['css'])){ ?>
<?php if(empty($_THEMES)){ ?>
<link href="assets/css/mikmos_style.css" rel="stylesheet">
<?php }else{ ?>
<link href="assets/css/styles/<?php _e($_THEMES);?>/mikmos_style.css" rel="stylesheet">
<?php } ?>
<?php }else{ ?>
<link href="assets/css/styles/<?php _e($_SESSION['css']);?>/mikmos_style.css" rel="stylesheet">
<?php } ?>
<script>
  function PassUser(){
var x = document.getElementById('passUser');
if (x.type === 'password') {
x.type = 'text';
} else {
x.type = 'password';
}}
</script>
<style>
body {background-color: transparent!important;}html {background-image: url("assets/images/seri.jpg");height: 100%;background-position: center;background-repeat: no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;}
</style>
</head>
<body class="fix-header fix-sidebar">
<div class="preloader">
<svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
</div>
<div id="main-wrapper">
<div class="header">
<nav class="navbar top-navbar navbar-expand-md navbar-light">
<div class="navbar-header">
<a class="navbar-brand" href="?load=home">
<?php if(empty($_SESSION['css'])){ ?>
<?php if(empty($_THEMES)){ ?>
<b><img src="assets/images/logo.png"/></b>
<span><img src="assets/images/logo-text.png"/></span>
<?php }else{ ?>
<b><img src="assets/css/styles/<?php _e($_THEMES);?>/logo.png"/></b>
<span><img src="assets/css/styles/<?php _e($_THEMES);?>/logo-text.png"/></span>
<?php } ?>
<?php }else{ ?>
<b><img src="assets/css/styles/<?php _e($_SESSION['css']);?>/logo.png"/></b>
<span><img src="assets/css/styles/<?php _e($_SESSION['css']);?>/logo-text.png"/></span>
<?php } ?>
</a>
</div>
<div class="navbar-collapse">
<ul class="navbar-nav mr-auto mt-md-0">
<li class="nav-item dropdown">
<a title="<?php echo __LANGS;?>" class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-list"></i></a>
<div class="dropdown-menu animated zoomIn">
<a class="dropdown-item" href="#id" onclick="doGTranslate('id|id');return false;" title="Indonesian">ID</a>
<a class="dropdown-item" href="#su" onclick="doGTranslate('id|su');return false;" title="Indonesian - Sunda">ID-SU</a>
<a class="dropdown-item" href="#jw" onclick="doGTranslate('id|jw');return false;" title="Indonesian - Jawa">ID-JV</a>
<a class="dropdown-item" href="#en" onclick="doGTranslate('id|en');return false;" title="English">EN</a>
<a class="dropdown-item" href="#ar" onclick="doGTranslate('id|ar');return false;" title="Arabic">AR</a>
</div>
<div id="google_translate_element2"></div>
<script type="text/javascript">
function googleTranslateElementInit2() {new google.translate.TranslateElement({pageLanguage: 'id',autoDisplay: false}, 'google_translate_element2');}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script>
<script type="text/javascript">
/* <![CDATA[ */
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('6 7(a,b){n{4(2.9){3 c=2.9("o");c.p(b,f,f);a.q(c)}g{3 c=2.r();a.s(\'t\'+b,c)}}u(e){}}6 h(a){4(a.8)a=a.8;4(a==\'\')v;3 b=a.w(\'|\')[1];3 c;3 d=2.x(\'y\');z(3 i=0;i<d.5;i++)4(d[i].A==\'B-C-D\')c=d[i];4(2.j(\'k\')==E||2.j(\'k\').l.5==0||c.5==0||c.l.5==0){F(6(){h(a)},G)}g{c.8=b;7(c,\'m\');7(c,\'m\')}}',43,43,'||document|var|if|length|function|GTranslateFireEvent|value|createEvent||||||true|else|doGTranslate||getElementById|google_translate_element2|innerHTML|change|try|HTMLEvents|initEvent|dispatchEvent|createEventObject|fireEvent|on|catch|return|split|getElementsByTagName|select|for|className|goog|te|combo|null|setTimeout|500'.split('|'),0,{}))
/* ]]> */
</script>
</li>
</ul>
</div>
</nav>
</div>

<?php if(!empty($_ceklog)){ ?>
<?php _e($_ceklog);?>
<?php } ?>
<div class="unix-login ">
<div class="container-fluid">
<div class="row justify-content-center">
<div class="col-lg-4">
<div class="login-content card ">
<div class="login-form">
<h4 style="text-transform:uppercase"><?php _e(__LOGIN_UR_ACCOUNT);?></h4>
<form class="form-signin" method="post" action="?index=login">
<div class="form-group">
<label><?php _e(__USERNAME);?></label>
<input type="text" class="form-control" id="signin-email" name="username" required placeholder="<?php _e(__USERNAME);?>" autocomplete="off" autofocus>
</div>
<div class="form-group">
<label><?php _e(__PASSWORD);?></label>
<div class="input-group input-group-flat">
<input id="passUser" type="password" class="form-control" id="signin-password" data-minlength="5" name="password" required placeholder="&bull;&bull;&bull;&bull;&bull;">
<span class="input-group-btn"><span class="btn btn-danger" onclick="PassUser()"><i class="fa fa-eye"></i></span></span>
</div>
</div>
<div class="checkbox">
<label>
<input type="checkbox" name="level" value="ADMIN" required> Check Me
</label>
<label class="pull-right">
<a href="./?index=forgot">Lupa Password?</a>
</label>
</div>
<button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Sign in</button>
</form>
</div>
</div>
<div class="register-link m-t-15 text-center">
<p>MIKMOS &copy; 2018</p>
</div>
</div>
</div>
</div>
</div>
</div>
<script src="assets/js/lib/jquery/jquery.min.js"></script>
<script src="assets/js/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/sidebarmenu.js"></script>
<script src="assets/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="assets/js/mikmos_script.js"></script>
</body>
</html>