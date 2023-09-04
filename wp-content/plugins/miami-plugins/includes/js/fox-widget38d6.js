function fox_loadTabContent(tab_name, page_num, container, args_obj) {
    
    var container = jQuery(container);
    var tab_content = container.find('#'+tab_name+'-tab-content');
        
    // only load content if it wasn't already loaded
    var isLoaded = tab_content.data('loaded');
    
    if (!isLoaded || page_num != 1) {
        if (!container.hasClass('fox-loading')) {
            container.addClass('fox-loading');
            
            tab_content.load(fox.ajax_url, {
                    action: 'fox_widget_content',
                    tab: tab_name,
                    page: page_num,
                    args: args_obj
                }, function() {
                    container.removeClass('fox-loading');
                    tab_content.data('loaded', 1).hide().fadeIn().siblings().hide();
                }
            );
        }
    } else {
        tab_content.fadeIn().siblings().hide();
    }
}

jQuery(document).ready(function() {
    jQuery('.fox_widget_content').each(function() {
        var $this = jQuery(this);
        var widget_id = this.id;
        var args = $this.data('args');
        
        // load tab content on click
        $this.find('.fox-tabs a').click(function(e) {
            e.preventDefault();
            jQuery(this).parent().addClass('selected').siblings().removeClass('selected');
            var tab_name = this.id.slice(0, -4); // -tab
            fox_loadTabContent(tab_name, 1, $this, args);
        });
        
        // pagination
        $this.on('click', '.fox-pagination a', function(e) {
            e.preventDefault();
            var $this_a = jQuery(this);
            var tab_name = $this_a.closest('.tab-content').attr('id').slice(0, -12); // -tab-content
            var page_num = parseInt($this_a.closest('.tab-content').children('.page_num').val());

            if ( $this_a.hasClass('next') ) {
                fox_loadTabContent(tab_name, page_num + 1, $this, args);
            } else {
                $this.find('#'+tab_name+'-tab-content').data('loaded', 0);
                fox_loadTabContent(tab_name, page_num - 1, $this, args);
            }
            
        });      
        // load first tab now
        $this.find('.fox-tabs a').first().click();
    });    
});