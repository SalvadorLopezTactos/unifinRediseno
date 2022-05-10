<?php
require_once 'include/Expressions/Expression/String/StringExpression.php';

class InicialesExpression extends StringExpression {

	function evaluate() {
		$param =$this->getParameters();
		if (is_array($param))
			$param = $param[0];
    $nombre = $param->evaluate();
    $nombres = explode(" ", $nombre);
    $iniciales = '';
    foreach($nombres as $name){
      $iniciales = $iniciales . substr($name,0,1);
    }
		return $iniciales;
	}

	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var nombre = this.getParameters().evaluate() + "";
      var nombres = nombre.split(" ");
      var iniciales = '';
      nombres.forEach(function(name) {
        iniciales = iniciales + name.substr(0,1);
      });
			return iniciales;
EOQ;
	}

	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "iniciales";
	}

	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
	}

    /**
     * Return param count to prevent errors.
     */
    public static function getParamCount()
    {
        return 1;
    }
}
?>
