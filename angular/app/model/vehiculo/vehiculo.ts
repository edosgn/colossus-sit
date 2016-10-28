export class Vehiculo{
	constructor(
		public id:number,
		public claseId:number,
		public municipioId:number,
		public lineaId:number,
		public servicioId:number,
		public colorId:number,
		public combustibleId:number,
		public carroceriaId:number,
		public organismoTransitoId:number,
		public placa:string,
		public numeroFactura:string,
		public fechaFactura:string,
		public valor:string,
		public numeroManifiesto:string,
		public fechaManifiesto:string,
		public cilindraje:string,
		public modelo:string,
		public motor:string,
		public chasis:string,
		public serie:string,
		public vin:number,
		public numeroPasajeros:number
		public pignorado:number,
		public cancelado:number
		
	){}
}