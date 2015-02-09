<?php
    $sourceId = get_option('cskt_source_id');
    $clientId = get_option('cskt_client_id');
    if (is_numeric($sourceId) && is_numeric($clientId) && 0 !== (int) $sourceId) {
        ?>
        <script>
            var sourceId = <?php echo $sourceId; ?>;
            var clientId = <?php echo $clientId; ?>;
            (function(l,o,v,e) { l.ownerid = sourceId;l.clientid = clientId;a=o.getElementsByTagName(v)[0];b=o.createElement(v);b.src=e;a.parentNode.insertBefore(b,a);})(window, document, 'script', 'https://api.crowdskout.com/analytics.js');
        </script>
        <?php
    }
?>
