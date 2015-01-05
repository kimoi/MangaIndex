<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width" />
    <meta name="mobile-web-app-capable" content="yes">

    <title><?php if(isset($pageTitle) && !empty($pageTitle)): ?>{{{ $pageTitle }}} - <?php endif; ?>/a/ manga</title>

    <link rel="icon" type="image/png" href="/img/icon.png">

    {{ Minify::stylesheet(array($stylesheets)) }}
</head>
<body>
    @yield('pageHeading')

    <div class="search-container">
        <form method="get" action="/search">
            <input type="text" name="q" placeholder="Search" class="input" id="search-input" required />
            <button class="button">Search</button>
        </form>

        <a href="/recent" class="button">Recent uploads</a>

        <?php if($user): ?>
            <a href="/user/notifications" class="button">
                Notifications

                <?php if($notifyCount > 0): ?>
                    <span class="notify-label">{{{ $notifyCount }}}</span>
                <?php endif; ?>
            </a>
        <?php endif; ?>
    </div> 

    <?php if(Session::has('error')): ?>
        <div class="message message-error">{{{ Session::get('error') }}}</div>
    <?php endif; ?>

    <?php if(Session::has('success')): ?>
        <div class="message message-success">{{{ Session::get('success') }}}</div>
    <?php endif; ?>

    @section('main')
        <div id="loli-madokai-container">
            <div id="loli-madokami"></div>
        </div>
    @show

    <footer>
        {{{ $statTotalSize }}}<br/>
        #madokami @ rizon<br/>
        <a href="http://fufufu.moe/" target="_blank">fufufu.moe</a>
    </footer>

    {{ Minify::javascript(array($javascripts)) }}

    <?php if(isset($gaId)): ?>
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', '{{{ $gaId }}}', 'auto');
          ga('send', 'pageview');
        </script>
    <?php endif; ?>
</body>
</html>