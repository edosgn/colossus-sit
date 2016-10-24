export class TramiteGeneral{
	constructor(
		public id:number,
		public vehiculoId:number,
		public numeroQpl:number,
		public fechaInicial:string,
		public fechaFinal:string,
		public valor:number,
		public numeroLicencia:number,
		public numeroSustrato:number,
		public nombre:string,
		public apoderado:boolean,
		public empresaId:number,
		public ciudadanoId:number

	){}
}