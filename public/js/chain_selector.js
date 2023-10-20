function ChainItem(sounds, range, volume)
{
	this.range = range;
	if (volume===undefined)
	{
		volume = 1.0;
	}
	this.volume = volume;
	this.sound = new Howl({urls:sounds, loop: true, volume:volume});
	this.getWeight = function (value) {
		if (value<this.range[0])
		{
			return 0;
		} 
		else if (value<this.range[1])
		{
			var c =  80.0/(range[1]-range[0]);
			var o = -1*(80+c*(range[1]+range[0]))/2;
			var a_db = c*value+o;
			var a_lin = this.volume*Math.exp(a_db/20.0);
			return a_lin;
		} else if (value<this.range[2]) {
			return this.volume;
		} else if (value<this.range[3]) {
			var c =  80.0/(range[2]-range[3]);
			var o = -1*(80+c*(range[3]+range[2]))/2;
			var a_db = c*value+o;
			var a_lin = this.volume*Math.exp(a_db/20.0);
			return a_lin;
		} else {
			return 0;
		}
	};
	
	this.setPosition = function (pos) {
		var weight = this.getWeight(pos);
		this.weight = weight;
		this.sound.volume(weight*this.volume);
	};
	
	this.fadeIn = function (target, duration) {
		this.volume = target;
		this.sound.fadeIn(target*this.weight, duration);
	};
	this.fadeOut = function (target, duration) {
		this.volume = target;
		this.sound.fadeOut(target*this.weight, duration);
	};
	this.volume = function (volume) {
		this.volume = volume;
		this.sound.volume(volume*this.weight);
	};
	
}

function ChainSelector(dictionary)
{
	this.dic = dictionary;
	this.items = [];
	this.make_from_dic = function (dic) {
		for (i=0; i<dic.length; i++)
		{
			var item = dic[i];
			this.items.push(new ChainItem(item.sound, item.range));
		}
	};
	this.make_from_dic(dictionary);
	this.set_pos = function (pos, play) {
		if (play===undefined)
		{
			play = false;
		}
		var feed = [];
		for (i=0; i<this.items.length; i++) {
			item = this.items[i];
			item.setPosition(pos);
			feed.push(item.sound.volume);
			if (play===true) {
				item.sound.play();
			}
		}
	};

	this.play = function (pos, volume) {
		if (volume===undefined)
		{
			volume = 1.0;
		}
		for (i=0; i<this.items.length; i++) {
			this.items[i].volume(volume);
		}
		this.set_pos(pos, true);
	};
	
	this.fadeIn = function(target, duration) {
		for (i=0; i<this.items.length; i++) {
			this.items[i].fadeIn(target, duration);
		}
	};
	
	this.fadeOut = function(target, duration) {
		for (i=0; i<this.items.length; i++) {
			this.items[i].fadeOut(target, duration);
		}
	};
	
	this.getWeights = function() {
		var feedback = [];
		for (i=0; i<this.items.length; i++) {
			feedback.push(this.items[i].weight);
		}
		return feedback;
	};
}
