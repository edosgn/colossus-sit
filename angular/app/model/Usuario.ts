export class Usuario{
	constructor(
		public id:string,
		public nombres:string,
		public apellidos:string,
		public identificacion:string,
		public correo:string,
		public foto:string,
		public telefono:string,
		public fecha_nacimiento:string,
		public estado:string,
		public rol:string,
		public password:string
	){}
}