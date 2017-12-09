<?php
	function get_model_price($model_mass_g, $material_cost_per_g) {
		$cost = (floatval($material_cost_per_g) / 100) * $model_mass_g;
		return $cost;
	}

?>