<?php

declare(strict_types=1);

namespace Tests\Support\Traits;

use ReflectionObject;

trait Non_Public_Accessor_Trait {
	public function get_object_property( $obj, $property_name) {
		$r = new ReflectionObject($obj);
		$p = $r->getProperty($property_name);
		$p->setAccessible(true);

		return $p->getValue($obj);
	}

	public function set_object_property( $obj, $property_name, $value) {
		$r = new ReflectionObject($obj);
		$p = $r->getProperty($property_name);
		$p->setAccessible(true);

		$p->setValue($obj, $value);
	}
}
