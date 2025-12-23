<div class="gallery-filters">
    <div class="filters-row">

        <!-- Filtre Catégorie -->
        <div class="filter-group">
            <select id="filter-categorie" class="filter-select">
                <option value="">CATÉGORIES</option>
                <?php
                $categories = get_terms([
                    'taxonomy' => 'categorie',
                    'hide_empty' => true,
                ]);
                if ($categories && !is_wp_error($categories)) :
                    foreach ($categories as $cat) : ?>
                        <option value="<?php echo esc_attr($cat->slug); ?>">
                            <?php echo esc_html($cat->name); ?>
                        </option>
                <?php endforeach;
                endif;
                ?>
            </select>
        </div>

        <!-- Filtre Format -->
        <div class="filter-group">
            <select id="filter-format" class="filter-select">
                <option value="">FORMATS</option>
                <?php
                $formats = get_terms([
                    'taxonomy' => 'format',
                    'hide_empty' => true,
                ]);
                if ($formats && !is_wp_error($formats)) :
                    foreach ($formats as $format) : ?>
                        <option value="<?php echo esc_attr($format->slug); ?>">
                            <?php echo esc_html($format->name); ?>
                        </option>
                <?php endforeach;
                endif;
                ?>
            </select>
        </div>

        <!-- Filtre Tri par date -->
        <div class="filter-group">
            <select id="filter-order" class="filter-select">
                <option value="">TRIER PAR</option>
                <option value="DESC">À partir des plus récentes</option>
                <option value="ASC">À partir des plus anciennes</option>
            </select>
        </div>

    </div>
</div>