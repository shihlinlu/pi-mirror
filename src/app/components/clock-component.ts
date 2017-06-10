/**
 * Created by primary on 6/10/17.
 */

import {Component} from "@angular/core";
import {ClockService} from "../services/clock-service";

@Component({
    selector: 'clock',
    templateUrl: "./templates/clock.php",
    styleUrls: ['./app.css']
})
export class Clock implements OnInit, OnDestroy {

    private _clockSubscription: Subscription;
    time: Date;

    constructor(private clockService: ClockService) { }

    ngOnInit(): void {
        this._clockSubscription = this.clockService.getClock().subscribe(time => this.time = time);
    }

    ngOnDestroy(): void {
        this._clockSubscription.unsubscribe();
    }

}