export class Ciudadano{
	constructor(
		public id:number,
		public tipoIdentificacionId:string,
		public numeroIdentificacion:number,
		public nombres:string,
		public apellidos:string,
		public direccion:string,
		public telefono:string,
		public correo:string
	){}
}