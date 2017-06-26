import {Component, OnInit} from "@angular/core";
import { PubNubAngular } from 'pubnub-angular2';
declare var PubNub: any;

@Component({
	selector: "tea",
	templateUrl: "templates/tea.php"
})

export class TeaComponent implements OnInit {
	//tea : Tea = new Tea(null);
	pubnub: PubNubAngular = null;
	channel : string;

	constructor() {
		this.pubnub = new PubNubAngular();
		this.channel = "snack";
		this.pubnub.init({
			publishKey: 'pub-c-0fad7fd8-eb53-401e-9af9-a86b1f134dfd',
			subscribeKey: 'sub-c-53061538-4e36-11e7-ab90-02ee2ddab7fe'
		});
		this.pubnub.subscribe({
			channels: ["snack"],
			triggerEvents: ['message'],
			withPresence: true
		});
	}

	ngOnInit() {

		/*setInterval(() => {
			let hw = 'Hello World, ' + Date.now();
			this.pubnub.publish({
				channel: this.channel, message: hw
			});
		}, 1000);*/
	}

	/*
	getTea(): void {
		this.teaService.getTea()
			.subscribe(tea => this.tea = tea);
	}
	*/

}