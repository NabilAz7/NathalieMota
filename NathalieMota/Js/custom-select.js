jQuery(document).ready(function($) {
    
    console.log('Custom select chargé !');
    console.log('Nombre de selects trouvés:', $('.filter-select').length);
    
    // Attendre que tout soit bien chargé
    setTimeout(function() {
        initCustomSelects();
    }, 100);
    
    function initCustomSelects() {
        // Transformer chaque select en custom select
        $('.filter-select').each(function() {
            let $select = $(this);
            
            // Vérifier si déjà transformé
            if ($select.next('.custom-select-wrapper').length > 0) {
                return;
            }
            
            let $wrapper = $('<div class="custom-select-wrapper"></div>');
            let $display = $('<div class="custom-select-display"></div>');
            let $dropdown = $('<div class="custom-select-dropdown"></div>');
            
            // Texte par défaut
            let defaultText = $select.find('option:first').text();
            $display.text(defaultText);
            
            // Créer les options
            $select.find('option').each(function(index) {
                let $option = $(this);
                let $item = $('<div class="custom-select-item" data-value="' + $option.val() + '">' + $option.text() + '</div>');
                
                if (index === 0) {
                    $item.addClass('default');
                }
                
                $dropdown.append($item);
            });
            
            // Assembler
            $wrapper.append($display);
            $wrapper.append($dropdown);
            $select.after($wrapper);
            $select.hide();
            
            console.log('Select transformé:', $select.attr('id'));
            
            // Toggle dropdown
            $display.on('click', function(e) {
                e.stopPropagation();
                $('.custom-select-wrapper').not($wrapper).removeClass('open');
                $wrapper.toggleClass('open');
            });
            
            // Sélection d'un item
            $dropdown.find('.custom-select-item').on('click', function() {
                let value = $(this).data('value');
                let text = $(this).text();
                
                $display.text(text);
                $select.val(value).trigger('change');
                $wrapper.removeClass('open');
                
                // Mettre à jour l'item actif
                $dropdown.find('.custom-select-item').removeClass('active');
                $(this).addClass('active');
            });
            
            // Fermer au clic extérieur
            $(document).on('click', function() {
                $wrapper.removeClass('open');
            });
        });
        
        console.log('Initialisation terminée');
    }
    
});