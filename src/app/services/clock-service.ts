/**
 * Created by primary on 6/10/17.
 */

import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {Clock} from "../classes/slack";
import {BaseService} from "./base-service";

@Injectable()
export class ClockService {

    private clock: Observable<Date>;

    constructor() {
        this.clock = Observable.interval(1000).map(tick => new Date()).share();
    }

    getClock(): Observable<Date> {
        return this.clock;
    }

}