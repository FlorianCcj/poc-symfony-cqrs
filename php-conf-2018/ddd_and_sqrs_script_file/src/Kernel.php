// Kernel.php

protected function build(Container $container)
{
	// all class which implement CommanHandler will be tag with ddd.command_handler  
	$container
		->registerForAutoconfiguration(CommanHandler::class)
		->addTag('ddd.command_handler')
	;
}