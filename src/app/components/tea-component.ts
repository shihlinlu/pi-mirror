import {Component, OnInit} from "@angular/core";
import { PubNubAngular } from 'pubnub-angular2';
import { TeaService } from '../services/tea-service';

@Component({
	selector: "tea",
	templateUrl: "./templates/tea.php",
	providers: [PubNubAngular]

})

export class TeaComponent implements OnInit {
	//tea : Tea = new Tea(null);
	pubnub: PubNubAngular;
	channel: string;
	constructor(protected teaService: TeaService, pubnub: PubNubAngular) {
		this.channel = 'tea';
		this.pubnub = pubnub;
		this.pubnub.init({
			publishKey: 'publish',
			subscribeKey: 'subscribe'
		});
		this.pubnub.subscribe({
			channels: [this.channel],
			triggerEvents: ['message']
		});
	}
	ngOnInit() {
		setInterval(() => {
			let hw = 'Hello World, ' + Date.now();
			this.pubnub.publish({
				channel: this.channel, message: hw
			});
		}, 1000);
	}

	/*
	getTea(): void {
		this.teaService.getTea()
			.subscribe(tea => this.tea = tea);
	}
	*/

}