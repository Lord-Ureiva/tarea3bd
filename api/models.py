from datetime import datetime
from flask_sqlalchemy import SQLAlchemy
# Importamos para realizar consultas personalizadas
from sqlalchemy import text

db = SQLAlchemy()

#Clase usuario_tiene_moneda
class usuario_tiene_moneda(db.Model):
	__tablename__ = 'usuario_tiene_moneda'
	id_usuario = db.Column(db.Integer, db.ForeignKey('usuario.id'), primary_key=True,)
	id_moneda  = db.Column(db.Integer, db.ForeignKey('moneda.id'), primary_key=True)
	balance = db.Column(db.Float, nullable = False)
	moneda = db.relationship('moneda')
	#usuario = db.relationship('usuario')

class cuenta_bancaria(db.Model):
	__tablename__ = 'cuenta_bancaria'
	numero_cuenta = db.Column(db.Integer, primary_key=True)
	id_usuario = db.Column(db.Integer, db.ForeignKey('usuario.id'))
	balance = db.Column(db.Float, nullable = False)

class pais(db.Model):
	__tablename__ = "pais"
	cod_pais = db.Column(db.Integer,primary_key = True)
	nombre = db.Column(db.String(45),nullable = False)
	usuarios = db.relationship('usuario',uselist= True)
	
	def json(self):
		return {
			'cod_pais': self.cod_pais,
			'nombre': self.nombre,
		}

class usuario(db.Model):
	__tablename__ = "usuario"
	id = db.Column(db.Integer,primary_key = True)
	nombre = db.Column(db.String(50),nullable = False)
	apellido = db.Column(db.String(50))
	correo = db.Column(db.String(50),nullable = False)
	contraseña = db.Column(db.String(256),nullable = False)  #Se ponen 256 en vez de 50 para que no existan problemas en caso de hacer Hash
	pais = db.Column(db.Integer, db.ForeignKey("pais.cod_pais"),nullable = False)
	fecha_registro = db.Column(db.DateTime(),nullable=False, default=db.func.current_timestamp())
	cuentas_bancarias = db.relationship('cuenta_bancaria',uselist= True)
	usuario_tiene_monedas = db.relationship('usuario_tiene_moneda',uselist= True)
	
class moneda(db.Model):
	__tablename__ = "moneda"
	id = db.Column(db.Integer, primary_key=True)
	sigla = db.Column(db.String(10), nullable = False)
	nombre = db.Column(db.String(80), nullable = False)
	precios_moneda = db.relationship("precio_moneda")
	

class precio_moneda(db.Model):
	__tablename__ = "precio_moneda"
	id_moneda = db.Column(db.Integer, db.ForeignKey("moneda.id"), primary_key = True)
	fecha = db.Column(db.DateTime(), primary_key = True)
	valor = db.Column(db.Float, nullable = False)
	
"""
# Creamos la entidad User
class User(db.Model):
	__tablename__ = 'user'
	id = db.Column(db.Integer, primary_key=True)
	username = db.Column(db.String(50), nullable=False) 
	# Añadimos la relación
	tasks = db.relationship('Task', cascade="all,delete", backref="parent", lazy='dynamic')
	created_at = db.Column(db.DateTime(), nullable=False, default=db.func.current_timestamp())
	

	@classmethod
	def create(cls, username):
		# Instanciamos un nuevo usuario y lo guardamos en la bd
		user = User(username=username)
		return user.save()

	def save(self):
		try:
			db.session.add(self)
			db.session.commit()

			return self
		except:
			return False
	def json(self):
		return {
			'id': self.id,
			'username': self.username,
			'created_at': self.created_at
		}

	def update(self):
		self.save()

	def delete(self):
		try:
			db.session.delete(self)
			db.session.commit()

			return True
		except:
			return False
	"""
			
"""			
class Task(db.Model):
	__tablename__ = 'task'
	id = db.Column(db.Integer, primary_key=True)
	description = db.Column(db.Text())
	user_id = db.Column(db.Integer, db.ForeignKey('user.id'))
	user = db.relationship("User")
	created_at = db.Column(db.DateTime, default=db.func.current_timestamp())

	@classmethod
	def create(cls, description, user_id):
		# Instanciamos un nuevo usuario y lo guardamos en la bd
		task = Task(description=description,user_id=user_id)
		return task.save()

	def save(self):
		try:
			db.session.add(self)
			db.session.commit()

			return self
		except:
			return False
	def json(self):
		return {
			'id': self.id,
			'description': self.description,
			'user_id':self.user_id,
			'created_at': self.created_at
		}
	def update(self):
		self.save()
	def delete(self):
		try:
			db.session.delete(self)
			db.session.commit()

			return True
		except:
			return False

	def custom(max_id):
		try:
			result = db.session.execute('SELECT * FROM task WHERE id <= :max', {'max': max_id})
			return result
		except:
			return False
	"""