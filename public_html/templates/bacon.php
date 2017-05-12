<h1>Bacon Component</h1>
<form #baconForm="ngForm" class="form-horizontal" name="baconForm" id="baconForm" novalidate>
	<div class="form-group" [ngClass]="{ 'has-error': baconNumParagraphs.touched && baconNumParagraphs.invalid }">
		<label for="baconNumParagraphs">Number of Paragraphs</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-hashtag" aria-hidden="true"></i>
			</div>
			<input type="number" id="baconNumParagraphs" name="baconNumParagraphs" class="form-control" required min="0" max="9" step="1" [(ngModel)]="numParagraphs" #baconNumParagraphs="ngModel" (change)="getBacon();" />
		</div>
		<div [hidden]="baconNumParagraphs.valid || baconNumParagraphs.pristine" class="alert alert-danger" role="alert">
			<p *ngIf="baconNumParagraphs.errors?.max">Number of paragraphs cannot be more than 10.</p>
			<p *ngIf="baconNumParagraphs.errors?.min">Number of paragraphs is cannot be negative.</p>
			<p *ngIf="baconNumParagraphs.errors?.required">Number of paragraphs required.</p>
		</div>
	</div>
</form>
<p *ngFor="let paragraph of paragraphs">{{ paragraph }}</p>