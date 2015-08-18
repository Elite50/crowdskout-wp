<script>
    (function(l,o,v,e,d) {
        l.cs=l.cs || function() {cs.q.push(arguments);};
        cs.q=cs.q||[];cs.apiUrl=d;cs('pageView');
        l.sourceId = <?php echo get_option('cskt_source_id'); ?>;l.clientId = <?php echo get_option('cskt_client_id'); ?>;l.organizationId = <?php echo get_option('cskt_organization_id'); ?>;
        a=o.getElementsByTagName(v)[0];b=o.createElement(v);b.src=e+'/analytics.js';a.parentNode.insertBefore(b,a);
    })(window, document, 'script', '//s.crowdskout.com','https://a.crowdskout.com');
</script>
