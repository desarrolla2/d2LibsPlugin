<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', '<?php echo $analytics_account ?>']);
    _gaq.push(['_setCustomVar', 1, 'territorial_id', '<?php echo $sf_user->getTerritorialId() ?>', 2 ]);
    _gaq.push(['_setCustomVar', 2, 'territorial', '<?php echo $sf_user->getTerritorial() ?>', 2 ]);
    _gaq.push(['_trackEvent', '<?php echo $sf_context->getModuleName(); ?>', '<?php echo $sf_context->getActionName(); ?>', ]);
    _gaq.push(['_trackPageview']);
    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>
