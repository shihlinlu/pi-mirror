/**
 * Created by Tucker on 6/10/17.
 */

import {Component, OnInit, OnDestroy} from "@angular/core";
import {ClockService} from "../services/clock-service";

@Component({
    selector: 'clock',
    templateUrl: './clock.component.html',
    styleUrls: ['./clock.component.css']
})
export class ClockComponent {

    time: Date;

    constructor(private clockService: ClockService) {
    }

    ngOnInit() {
        this.clockService.getClock().subscribe(time => this.time = time);
    }

}