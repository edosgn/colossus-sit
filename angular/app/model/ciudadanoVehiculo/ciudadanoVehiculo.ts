export class CiudadanoVehiculo{
	constructor(
		public id:number,
		public ciudadanoId:number,
		public vehiculoId:number,
		public empresaId:number,
		public licenciaTransito:number,
		public fechaPropiedadInicial:string,
		public fechaPropiedadFinal:string,
		public estadoPropiedad:string
		
	){}
}