window.onload = function() {
	var div1 = document.getElementById('comment');
	var str = '';
	var len = 183;
	var aDiv = div1.getElementsByTagName('div');
	var timer = null;
	var num = 0;
	var arr = [' ', ' ', '学', '霸', '养', '成 ', '平 ', '台 ',
		'是 ',
		'一 ',
		'款 ',
		'以 ',
		'大 ',
		'学 ',
		'生 ',
		'为 ',
		'群 ',
		'体 ',
		'设 ',
		'计 ',
		'而 ',
		'成 ',
		'的 ',
		'学 ',
		'习 ',
		'软 ',
		'件 ',
		'丶',
		'是 ',
		'一 ',
		'个 ',
		'包 ',
		'括 ',
		'网 ',
		'上 ',
		'做 ',
		'题 ',
		'和 ',
		'老 ',
		'师 ',
		'辅 ',
		'导 ',
		'的',
		'丶',
		'网 ',
		'上 ',
		'自 ',
		'学 ',
		'丶',
		'网 ',
		'上 ',
		'师 ',
		'生 ',
		'交 ',
		'流 ',
		'丶',
		'网 ',
		'上 ',
		'作 ',
		'业 ',
		'丶',
		'网 ',
		'上 ',
		'测 ',
		'试 ',
		'丶',
		'以 ',
		'及 ',
		'质 ',
		'量 ',
		'评 ',
		'估 ',
		'等 ',
		'多 ',
		'种 ',
		'服 ',
		'务 ',
		'在 ',
		'内 ',
		'的 ',
		'丶',
		'综 ',
		'合 ',
		'学 ',
		'习 ',
		'服 ',
		'务 ',
		'支 ',
		'持 ',
		'系 ',
		'统 ',
		'丶',
		'它 ',
		'能 ',
		'为 ',
		'学 ',
		'生 ',
		'提 ',
		'供 ',
		'实',
		'时',
		'和',
		'非 ',
		'实 ',
		'时 ',
		'的 ',
		'教 ',
		'学 ',
		'辅 ',
		'导 ',
		'服 ',
		'务 ',
		'丶',
		'学 ',
		'生 ',
		'可 ',
		'以 ',
		'在 ',
		'此 ',
		'平 ',
		'台 ',
		'学 ',
		'习 ',
		' ',
		' ',
		' ',
		' ',
		' ',
		' ',
		' ',
		' ',
		' ',
		' ',
		' ',
		' ',
		' ',
		' ',
		'孔',
		'子', '说', '丶', '博', '学', '而', '笃', '志',
		'切', '问', '而', '近', '思', '，', '仁', '在',
		'其 ',
		'中 ',
		'矣 ',
		'最 ',
		'后 ',
		'丶 ',
		'放 ',
		'飞 ',
		'自 ',
		'己 ',
		'的 ',
		'青 ',
		'春 ',
		'用 ',
		'勤 ',
		'劳 ',
		'的 ',
		'汗 ',
		'水 ',
		'铺 ',
		'就 ',
		'未 ',
		'来 ',
		'的 ',
		'成 ',
		'功 ',
		'之 ',
		'路 ',
		'。'
	];

	function doOpacity(obj, attr, dir, target, endFn) {

		clearInterval(obj.timer);

		obj.timer = setInterval(function() {

			var speed = parseFloat(getStyle(obj, attr)) + dir; // 步长

			if(speed > target && dir > 0) {
				speed = target;
			}

			obj.style[attr] = speed;

			if(speed == target) {
				clearInterval(obj.timer);

				endFn && endFn();

			}

		}, 180);
	}

	function getStyle(obj, attr) {
		return obj.currentStyle ? obj.currentStyle[attr] : getComputedStyle(obj)[attr];
	}

	for(var i = 0; i < len; i++) {
		str += '<div style="position:absolute; 	top:' + parseInt(i / 17) * 30 + 'px; left:' + (i % 17) * 30 + 'px; opacity: 0;">' + arr[i] + '</div>';
	}

	div1.innerHTML = str;

	function start() {

		clearInterval(timer);

		timer = setInterval(function() {

			doOpacity(aDiv[num], 'opacity', 0.1, 1);
			num++;
			if(num === len) {
				clearInterval(timer);
			}
		}, 180);
	};
	start();
};