<?php
function cdwp_inject_cart_drawer() {
    
    global $woocommerce;
    
    $items = $woocommerce->cart->get_cart();
    
    ob_start();
    ?>
    <span class="menu">
    <span class="js-menu__open" data-menu="#main-nav">
    <span class="js-wsc-items-count"><?php echo esc_attr(count($items));?></span>
	<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAABmJLR0QA/wD/AP+gvaeTAAADCUlEQVRoge2Zy2tTQRSHv7RVsb6LglpFfHRRVESlqGilIIoUxQe48bVRaNGFS/sHuHAnrhR1pSDUjeBK1E2rUEVRhKaC4guhQVutKGKNtXHxm5g23jR37p2bWzEfhCmZ6e+cMzcz58wdKFOmzH9Bpcd3q4FXwBFgM1ALvAO+ltAvJ9QDvUBmxOc70BqnU2FYBOwCLgBDKKC9sXrkgP0okBdxO+KCZyiYlXE74kWFxdgu066KwpGw2ASSNO3yKBwJi00g3aZdEYUjpaQWrZHXcTviRcJy/CdgJrADSLt3xxefgUdhRToZnSjj+mzJd6zKMpBuoBF4Cjy3/N+wTEQJOgO8DSt23AidCSsUgN3G9j2vTptdC+LduQ6Z9ooLsRo0KykXYpZ2B1HxOsuVaAoFM8eVoA+OGZvXXIreNqJNLkWL0GVs7iw0wHaNQOnXSR2wDugDbhYaFCSQUtdch1Hivgr8dCm8Hj3muy5FC5BAx+4MsNa1+FRgGJUKtiWOLU0oiGSxgUHJztKCqAwY2o2dk1EZuGEMbI9IfwLQhp58Pz5yh22tlSWJtsLzxpBLEsBi5HwaOAoMOLbxhwNEW93+AjqATX4dCvpEsrmkhzGSVAhSqByJnEloT/9GsFw0rsi+HloWtyMQbjbH1cuIMIFkk9S4CCToYofcUXcfyvau6AeeoPcDTmsrL06ga4Yot+AeoMGvQ0FqpVbgHMq619GT2YjuUgAuAQ8t9FqANcAPVJKkgG3onuYjKuFfBvBzTKrRuWAY2JPXdwrNZIeF3kJ0hB1k9OxXorN5Bl1rOKeRwm8yqoAv6C6l2qfeQaN32aNvPhbvB2x3rRrT9nr0DQEf0GzO8Kk3ewy9PrTYp9s46Jc6NEu9wLS8vnr0kxvA/9rbavQe8/d9ZrPpux/U2WLcMQZuoaxeAWwgl+lPW2hVoXyUQWtinvmumdw9Zosrx/NZCrwht02mR/zdCUyx1GtAPyMvvXYiPoXOBc6ia+s02vPbgMkB9ZYAF4H3qBB9gJ5E1EfpMmXK/Gv8Bi6y+VBcFqTmAAAAAElFTkSuQmCC"/>
    </span>
</span>

<div class="js-menu__context">
    <div id="main-nav" class="js-menu js-menu--right">

	<div class="xoo-wsc-header">
	   <div class="xoo-wsch-top">
	      <div class="xoo-wsc-notice-container" data-section="cart" style="display: none;">
		 <ul class="xoo-wsc-notices"></ul>
	      </div>
	      <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAAABmJLR0QA/wD/AP+gvaeTAAADYElEQVRoge2ay07VUBSGv3PQIEoQENQgGgWjgakYJ0YMxjvGkTrWhBg0+g4OmTpEfQDnJk5IHPgCamIiJlwETTQcVOSEi9wcrFZKe9rutruXo/2SlR7C7ur/p/vS7q4CydAOXAf6gcPAQeAX8B4YBUaAl8ByQnpiow0YBlaADZ+YBR4BO1NRqoF+YA5/o/b4BJxOQW8k7gGrBDdrxiJwM3HVIekH1nCaeAM8ALqAXUZ0Aw+BtxXa/wZ6E9YemDac3XgRGACKHucVgbvAku3cb8DeGPVGZhin2TMBzu/FafqxZo3aaMc5Gw+EyDNoy7GM9JzMcR/nmPXqxm4UgXe2XIOaNIYS5MZV29/PgPUQedaNc61cCaUoZkbZele6IuTqtuX6EFldDMyzVWR9hFz1tlzzkdUZ6OzSJcvvCaAcIVcZmLT8PRMhV2xcBqaNuJTBfDk5Of8pd5CX9bCvfrpiFrgds1cakReCtM2asWBoUiboOnwO2BHwnDipA/qCnBDU8PmA7ZMgVk1jpN+N7TERl9mjGTDnFp2qJoJ06QsB2iaNsrYghrM4fk20a9sG/CT9rusWc8B2FSOqd/gUsFuxbRo0ACdVGqoaznJ3NlEax6qGszxhmWi7KY2ofQxLO1aBJj8zKne4D5m0sk4NcNavkYrhahi/Jlq02rdfsxyjfmZU7nCg16+UafBroGL4qQYhSfHEr0FBIUkBuIZMCMeBY0idRtoT2QpSLfAR6cqvgBdI13ZFxXAlisB+4BBwAPly2IIsC822Yw3y2Gd+iahls45jgc1ClrJhYg34AXy3HUvAZ+ALMAV8Jdy3q5x/Gr8u3QE8B14jux3jyA7DBOnXVNUic8kRRGcnUm1wC9FZEb+Jp8cSVjaQsTSOjKuSETNIXca8EUuW32Vkx7MSdUiRS4NxrDN+1wP7gFZkjmhF5owO41hplenBw7AfQ+h7KBgH9lS4RgvSY3RdZyisWZCSQJ1PQmPADWQGb0ZqsXRvDI54GfIawwVkSaimJy2Q3Y8mXNZjryetTqrPLMjOTIfbP70Mn9CvJTFcteeGLdiXomrCVbvXpDWDLBnVSAlZsx143eEoVThpE0r7ReT1K+1djKAxieaqn2lL8imdiTN63b/1U1MkWz+V1nVzcnJychLjD0wsWjFqkxyKAAAAAElFTkSuQmCC"/><span class="xoo-wsch-text">Your Cart</span>
	      <span class="xoo-wsch-close xoo-wsc-icon-cross js-menu__close">✕</span>
	   </div>
	   <div class="xoo-wsc-ship-bar-cont">
		<div class="xoo-wsc-sb-bar">
		    <span style="width: 50%;"></span>
		</div>
	    </div>
	</div>
	
	<div class="cart_response"></div>
	<div id="cover-spin"></div>
    </div>
</div>
    <?php
    echo $content = ob_get_clean();
}
add_action('wp_footer', 'cdwp_inject_cart_drawer');
?>