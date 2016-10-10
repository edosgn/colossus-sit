export class VehiculoPesado{
	constructor(
		public id:number,
		public modalidadId:number,
		public vehiculoId:number,
		public empresaId:number,
		public tonelaje:number,
		public numeroEjes:number,
		public numeroMt:number,
		public fichaTecnicaHomologacionCarroceria:string,
		public fichaTecnicaHomologacionChasis:string
	){}
}