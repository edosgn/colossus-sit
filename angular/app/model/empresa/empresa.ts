export class Empresa{
	constructor(
		public id:number,
		public municipioId:number,
		public tipoEmpresaId:number,
		public ciudadanoId:number,
		public nit:number,
		public nombre:string,
		public direccion:string,
		public telefono:string,
		public correo:string
	){}
}