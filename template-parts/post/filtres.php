<?php
		// Récupérer toutes les catégorie
		$taxonomy = 'categorie-acf';
		$categories = get_terms($taxonomy, array('hide_empty' => false, ));
		$category_filter = (isset($_GET['category'])) ? $_GET['category'] : '';

		// Récupérer toutes les fomrats
		$taxoFormat = 'format-acf';
		$formats = get_terms($taxoFormat,array('hide_empty' => false,));// Inclure les catégories sans articles
		$category_filter_format = (isset($_GET['category'])) ? $_GET['category'] : '';


	
?>	



<div class="category-filter">
	<form id="category-filter-form" action="' . esc_url(home_url()) . '" method="get">
		<div class="cat-form">
			<select  id="category-select" class="select" name="category">
					<option class="label" value="">CATÉGORIES</option>
					<?php 
						foreach ($categories as $category) :
						$selected = ($category->slug === $category_filter) ? 'selected' : '';
						echo '<option class="select" value="' . esc_attr($category->slug) . '" ' . $selected . '>' . esc_html($category->name) . '</option>';
						endforeach;
					?>
			</select>
			<select id="category-select-format" name="category">
				<option class="select" value="">FORMATS</option>
				<?php	
					foreach ($formats as $category) :
						$selected = ($category->slug === $category_filter_format) ? 'selected' : '';
						echo '<option class="select" value="' . esc_attr($category->slug) . '" ' . $selected . '>' . esc_html($category->name) . '</option>';
					endforeach;
				?>
			</select>
		</div>
		<div class="trie">
			<select  id="category-select-date" name="category">
				<option class="label" value="">TRIER PAR</option>
				<option class="label" value="date-asc">Plus ancien en premier</option>
				<option value="date-desc">Plus récent en premier</option>
			</select>
		</div>
	</form>
</div>


