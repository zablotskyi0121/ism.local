<?php

include _DIR_ . 'Templates/Header.phtml';
include _DIR_ . 'Templates/Menu.phtml'; //         \System\Renderer::render('Menu', ['product' => $product, 'categories' => $categories]);

include _DIR_ . 'Templates/' . $pageTemplate . '.phtml';
include _DIR_ . 'Templates/Footer.phtml';

