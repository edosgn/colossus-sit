export class Almacen{
	constructor(
		public id:number,
		public servicioId:number,
		public organismoTransitoId:number,
		public consumibleId:number,
		public claseId:number,
		public rangoInicio:number,
		public rangoFin:number,
		public lote:number
	){}
}