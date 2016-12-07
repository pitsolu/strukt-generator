<?php

namespace Strukt\Generator\Annotation;

/**
* Basic Annotation Generator Class
*
* @author Moderator <pitsolu@gmail.com>
*/
class Basic implements \Strukt\Generator\IAnnotation{

	/**
	* List of annotation key value pairs
	*
	* @var array
	*/
	private $annotList;

	/**
	* Store annotations in block
	*
	* @var array
	*/
	private $block;

	/**
     * Constructor
     *
     * @param array $annotation
     */
	public function __construct(array $annotList){

		$this->annotList = $annotList;
	}

	/**
     * Build DocBlock
     */
	protected function build(){

		foreach($this->annotList as $name=>$item){

			if(is_array($item)){

				if(\Strukt\Common\Util\Arr::isAssoc($item))
					$item = \Strukt\Core\HashMap::withEach($item, function($key, $val){

						return sprintf("%s=%s", $key, $val);
					});

				$item = implode(", ", $item);
			}

			$this->block[] = sprintf("* @%s(%s)", $name, $item);
		}
	}

	/**
     * Render DocBlock
     *
     * @return string
     */
	public function __toString(){

		$this->build();

		return sprintf("/**\n%s\n*/", implode("\n", $this->block));
	}
}