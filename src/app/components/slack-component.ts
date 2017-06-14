import {Component, OnInit} from "@angular/core";
import {SlackService} from "../services/slack-service";
import {Slack} from "../classes/slack";

@Component({
    selector: "slack",
    templateUrl: "./templates/slack.php",

})

export class SlackComponent implements OnInit {
    slack : Slack = new Slack(null, null, null, null);
    constructor(protected slackService: SlackService) {}

    getSlack(): void {
        this.slackService.getSlack()
			  .subscribe(slack => this.slack = slack);
    }

    ngOnInit() : void {
        this.getSlack();
    }

}