<div class="clearfix"></div>

<section class="sliderback" style="margin-top: 85px;">

	<div class="clearfix"></div>

	<div class="title-div text-center">
		<h1><span>W</span>elcome</h1>
	</div>
	<div class="tittle-style"></div>


	<div id="slider" class="col-md-6" style="margin-top: 30px;">
		<ul class="slider-wrapper">


			<?php 
      $resultt = mysqli_query($db, "SELECT * FROM slider");
    ?>
			<?php 
      $i = 1;
      while($row = mysqli_fetch_array($resultt)){ 
        if ($i == 1) {
          $active = 'current-slide';
        }else {
          $active = '';
        }
    ?>

			<li class="<?php echo $active; ?>">
				<img src="images/slider/<?php echo $row['image']; ?>" title="" alt="" style="width: 100%; height: 100%;">

				<div class="caption">
					<h2 class="slider-title">
						<?php echo $row['title']; ?>
					</h2>
					<p>
						<?php echo $row['sub_title']; ?>
					</p>
				</div>
			</li>

			<?php $i++; } ?>

		</ul>

		<ul id="control-buttons" class="control-buttons pull-right"></ul>
		<div class="clearfix"></div>
	</div>



	<div class="col-md-6" style="margin-top: 15px;">

		<div class="info">
			<div class="col-md-12">
				<?php 
            $result_about = mysqli_query($db, "SELECT * FROM about");
            $row_about = mysqli_fetch_array($result_about)
          ?>
				<p>
					<?php echo $row_about['about']; ?>
				</p>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
</section>
<div class="clearfix"></div>
<script type="text/javascript">
	/**
	 * @Titulo: Slider Responsivo
	 * @Autor: Creaticode
	 * @URL: http://creaticode.com 
	 */
	$(function() {
		/** -----------------------------------------
		 * Modulo del Slider 
		 -------------------------------------------*/
		var SliderModule = (function() {
			var pb = {};
			pb.el = $('#slider');
			pb.items = {
				panels: pb.el.find('.slider-wrapper > li'),
			}

			// Interval del Slider
			var SliderInterval,
				currentSlider = 0,
				nextSlider = 1,
				lengthSlider = pb.items.panels.length;

			// Constructor del Slider
			pb.init = function(settings) {
				this.settings = settings || {
					duration: 8000
				};
				var items = this.items,
					lengthPanels = items.panels.length,
					output = '';

				// Insertamos nuestros botones
				for (var i = 0; i < lengthPanels; i++) {
					if (i == 0) {
						output += '<li class="active"></li>';
					} else {
						output += '<li></li>';
					}
				}

				$('#control-buttons').html(output);

				// Activamos nuestro Slider
				activateSlider();
				// Eventos para los controles
				$('#control-buttons').on('click', 'li', function(e) {
					var $this = $(this);
					if (!(currentSlider === $this.index())) {
						changePanel($this.index());
					}
				});

			}

			// Funcion para activar el Slider
			var activateSlider = function() {
				SliderInterval = setInterval(pb.startSlider, pb.settings.duration);
			}

			// Funcion para la Animacion
			pb.startSlider = function() {
				var items = pb.items,
					controls = $('#control-buttons li');
				// Comprobamos si es el ultimo panel para reiniciar el conteo
				if (nextSlider >= lengthSlider) {
					nextSlider = 0;
					currentSlider = lengthSlider - 1;
				}

				controls.removeClass('active').eq(nextSlider).addClass('active');
				items.panels.eq(currentSlider).fadeOut('slow');
				items.panels.eq(nextSlider).fadeIn('slow');

				// Actualizamos los datos del slider
				currentSlider = nextSlider;
				nextSlider += 1;
			}

			// Funcion para Cambiar de Panel con Los Controles
			var changePanel = function(id) {
				clearInterval(SliderInterval);
				var items = pb.items,
					controls = $('#control-buttons li');
				// Comprobamos si el ID esta disponible entre los paneles
				if (id >= lengthSlider) {
					id = 0;
				} else if (id < 0) {
					id = lengthSlider - 1;
				}

				controls.removeClass('active').eq(id).addClass('active');
				items.panels.eq(currentSlider).fadeOut('slow');
				items.panels.eq(id).fadeIn('slow');

				// Volvemos a actualizar los datos del slider
				currentSlider = id;
				nextSlider = id + 1;
				// Reactivamos nuestro slider
				activateSlider();
			}

			return pb;
		}());

		SliderModule.init({
			duration: 4000
		});

	});

</script>
