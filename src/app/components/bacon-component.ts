import {Component, OnInit} from "@angular/core";
import {BaconService} from "../services/bacon-service";

@Component({
	templateUrl: "./templates/bacon.php"
})

export class BaconComponent implements OnInit {

	numParagraphs : number = 3;
	paragraphs : string[] = [];

	constructor(private baconService: BaconService) {}

	ngOnInit() : void {
		this.getBacon();
	}

	getBacon() : void {
		this.baconService.getBacon(this.numParagraphs)
			.subscribe(paragraphs => this.paragraphs = paragraphs);
	}

}