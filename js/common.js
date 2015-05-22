$(document).on('ready',function(){
	/* 変数set */
	var obj = {
			Win : $(window),
			Top : $('#top'),
			Key : $('#key'),
			About : $('#about'),
			Works : $('#works'),
			Contact : $('#contact'),
				Skill : $('#skill'),
				SklItem : $('#skill').find('li'),
				Cork : $('#corkbord')
		},
		_height = {
			Win : obj.Win.height(),
			Top : obj.Top.height(),
			Key : obj.Key.height(),
			About : obj.About.height(),
			Works : obj.Works.height(),
			Skill : obj.Skill.height(),
			Cork : obj.Cork.height()
		},
		_Top = {
			Key : obj.Key.offset().top,
			About : obj.About.offset().top,
			Works : obj.Works.offset().top,
			Contact : obj.Contact.offset().top,
				Skill : obj.Skill.offset().top,
				Cork : obj.Cork.offset().top
		},
		_bottom = {
			Key : _Top.Key + _height.Key,
			About : _Top.About + _height.About,
			Works : _Top.Works + _height.Works
		},
		_now = new Date().getHours();
	/*----------*/

	/* hidden */
		//フェードイン表示用
		$("head").append(
		'<style type="text/css">body {display: none;}</style>'
		);
		//スキルのグラフ表示用
		obj.SklItem.addClass('none');
		//スイング表示用
		obj.Cork.addClass('swing');
	/*----------*/


	//スクロール系処理
	obj.Win.on('scroll',function(){
		var scrTop = $(this).scrollTop();
//console.log();

		//#skillの位置までスクロールしたら表示
		if( (_Top.Skill + _height.Skill) <= (scrTop + _height.Win) ){
			obj.SklItem.removeClass('none');
		}
		//#corkbordの位置までスクロールしたら表示
		if( (_Top.Cork + _height.Cork/3) <= (scrTop + _height.Win) ){
			obj.Cork.removeClass('swing');
		}

		// if( _bottom.Key > scrTop ){
		// 	var	_speed = 1000,	//スクロールの速度
		// 		$position = _Top.Key - _height.Top;	// 移動先のoffset値取得
		// 	$('body,html').animate({scrollTop:$position}, _speed, 'swing');
		// }
		// if( _bottom.Key < (scrTop + _height.Win) ){
		// 	var	_speed = 1000,	//スクロールの速度
		// 		$position = _Top.About - _height.Top;	// 移動先のoffset値取得
		// 	$('body,html').animate({scrollTop:$position}, _speed, 'swing');
		// }
	});



	obj.Win.on('load',function(){
	//変数set

	//textAnimationの設定
// $('.textAnimate').each(function() {
// 	var $this_Top = $(this).offset().top;

// 		$(document).addEventListener("scroll",function(){
// 			var this = $(this),
// 				scrTop = this.scrollTop();
// 			if( this_Top <= scrTop ){
// 				this.textAnimation({
// 					speed: 1000,
// 					delay: 40,
// 					left: 100,
// 					top: 100,
// 					scale: 3,
// 					rotateY: 500,
// 					rotateX: 500,
// 					translateZ: 200,
// 					letterSpacing: '10px',
// 					easing: 'cubic-bezier(0.290, 0.350, 0.460, 1.200)',
// 					backgroundColor: 'transparent',
// 					isRandomScale: false,
// 					isRandomPosition: true,
// 					isRandomRotateY: true,
// 					isRandomRotateX: true,
// 					isRandomTranslateZ: true,
// 					isRandomSpeed: true,
// 					isRandomDelay: false
// 				});
// 			};
// 		});
// });


		//fadeInでbodyを読み込む
		$('body').fadeIn(600,function(){
			obj.Key.find('h1').css({
				'-webkit-filter':'blur(0px)',
				'filter':'blur(0px)'
			});
		});

		//ページスクロール移動処理
		$('a[href^=#]').on('click',function(){
			var $this = $(this),
				_speed = 1000,	//スクロールの速度
				$href = $this.attr("href"),	//アンカーの値取得
				$target = $($href == "#" || $href == "" ? 'html' : $href),	//移動先を取得
				$position = $target.offset().top - _height.Top;	// 移動先のoffset値取得
			$('body,html').animate({scrollTop:$position}, _speed, 'swing');
			return false; //URLに#が付く&デフォルト動作を回避
		});


		// var $code = $('#code');
		// $skillItem.each(function(){
		// 	var $text = $(this).html();
		// 	$(document).on('mouseover','#skill li',function(){
		// 		console.log($text);
		// 	});
		// });

		// for(i=0;i<7;i++){
		// 	$skillItem.eq(i).on('mouseover',function(){
		// 		console.log($(this).html());
		// 	});
		// }
	});
});