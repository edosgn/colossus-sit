export class Pago{
	constructor(
		public id:number,
		public tramiteId:number,
		public valor:number,
		public fechaPago:string,
		public horaPago:string,
		public fuente:string
	){}
}