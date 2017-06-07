export class Weather{
     constructor(public time: Date, public temperature: number, public apparentTemperature: number, public windSpeed: number, public windBearing: number, public summary: string, public icon: string) {}
}