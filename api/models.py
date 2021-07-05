from datetime import datetime
from flask_sqlalchemy import SQLAlchemy
# Importamos para realizar consultas personalizadas
from sqlalchemy import text

db = SQLAlchemy()

class Usuario_tiene_moneda(db.Model):
	__tablename__ = 'usuario_tiene_moneda'
	id_usuario = db.Column(db.Integer, db.ForeignKey('usuario.id'), primary_key=True)
	id_moneda  = db.Column(db.Integer, db.ForeignKey('moneda.id'), primary_key=True)
	balance = db.Column(db.Float, nullable = False)

	#moneda = db.relationship('Moneda', cascade ="all, delete-orphan")
	#usuario = db.relationship('usuario')
	
	@classmethod
	def create(cls, id_usuario, id_moneda, balance):
		# Instanciamos un nuevo usuario_tiene_moneda y lo guardamos en la bd
		usuario_tiene_moneda = Usuario_tiene_moneda(id_usuario = id_usuario, id_moneda = id_moneda, balance = balance)
		return usuario_tiene_moneda.save()

	def save(self):
		try:
			db.session.add(self)
			db.session.commit()

			return self
		except Exception as e :
			print(e)
			return False

	def json(self):
		return {
			'id_usuario': self.id_usuario,
			'id_moneda': self.id_moneda,
			'balance': self.balance,
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

class Cuenta_bancaria(db.Model):
	__tablename__ = 'cuenta_bancaria'
	numero_cuenta = db.Column(db.Integer, primary_key=True)
	id_usuario = db.Column(db.Integer, db.ForeignKey('usuario.id'))
	balance = db.Column(db.Float, nullable = False)
	
	@classmethod
	def create(cls, id_usuario, balance):
		# Instanciamos una nueva cuenta bancaria y lo guardamos en la bd
		cuenta_bancaria = Cuenta_bancaria(id_usuario = id_usuario, balance = balance)
		return cuenta_bancaria.save()

	def save(self):
		try:
			db.session.add(self)
			db.session.commit()

			return self
		except:
			return False

	def json(self):
		return {
			'numero_cuenta': self.numero_cuenta,
			'id_usuario': self.id_usuario,
			'balance': self.balance,
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

class Pais(db.Model):
	__tablename__ = "pais"
	cod_pais = db.Column(db.Integer,primary_key = True)
	nombre = db.Column(db.String(45),nullable = False)
	
	usuarios = db.relationship('Usuario',uselist= True, cascade ="all, delete-orphan")
	
	@classmethod
	def create(cls, nombre):
		# Instanciamos un nuevo pais y lo guardamos en la bd
		pais = Pais(nombre=nombre)
		return pais.save()

	def save(self):
		try:
			db.session.add(self)
			db.session.commit()

			return self
		except:
			return False

	def json(self):
		return {
			'cod_pais': self.cod_pais,
			'nombre': self.nombre,
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

class Usuario(db.Model):
	__tablename__ = "usuario"
	id = db.Column(db.Integer,primary_key = True)
	nombre = db.Column(db.String(50),nullable = False)
	apellido = db.Column(db.String(50))
	correo = db.Column(db.String(50),nullable = False)
	contraseña = db.Column(db.String(256),nullable = False)  #Se ponen 256 en vez de 50 para que no existan problemas en caso de hacer Hash
	pais = db.Column(db.Integer, db.ForeignKey("pais.cod_pais"),nullable = False)
	fecha_registro = db.Column(db.DateTime(),nullable=False, default=db.func.current_timestamp())
	
	cuentas_bancarias = db.relationship('Cuenta_bancaria',uselist= True, cascade ="all, delete-orphan")
	Usuario_tiene_monedas = db.relationship('Usuario_tiene_moneda',uselist= True, cascade ="all, delete-orphan")

	def json(self):
		return {
			'id': self.id,
			'nombre': self.nombre,
			'apellido': self.apellido,
			'correo': self.correo,
			'contraseña': self.contraseña,
			'pais': self.pais,
			'fecha_registro': self.fecha_registro,
		}

	def save(self):
		try:
			db.session.add(self)
			db.session.commit()

			return self
		except:
			return False
	
	@classmethod
	def create(cls, nombre,apellido,correo,contraseña,pais):
		# Instanciamos un nuevo usuario y lo guardamos en la bd
		usuario = Usuario(nombre=nombre, apellido = apellido, correo = correo, contraseña = contraseña, pais = pais)
		return usuario.save()
	
	def update(self):
		self.save()

	def delete(self):
		try:
			db.session.delete(self)
			db.session.commit()

			return True
		except:
			return False


class Moneda(db.Model):
	__tablename__ = "moneda"
	id = db.Column(db.Integer, primary_key=True)
	sigla = db.Column(db.String(10), nullable = False)
	nombre = db.Column(db.String(80), nullable = False)

	precios_moneda = db.relationship("Precio_moneda", cascade ="all, delete-orphan")
	usuario_tiene_moneda = db.relationship("Usuario_tiene_moneda", cascade ="all, delete-orphan")
	
	
	@classmethod
	def create(cls, sigla, nombre):
		# Instanciamos una nueva moneda y la guardamos en la bd
		moneda = Moneda(sigla=sigla, nombre=nombre)
		return moneda.save()

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
			'sigla': self.sigla,
			'nombre': self.nombre,
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
	
class Precio_moneda(db.Model):
	__tablename__ = "precio_moneda"
	id_moneda = db.Column(db.Integer, db.ForeignKey("moneda.id"), primary_key = True)
	fecha = db.Column(db.DateTime(), primary_key = True, default=db.func.current_timestamp())
	valor = db.Column(db.Float, nullable = False)

	@classmethod
	def create(cls, id_moneda, valor):
		# Instanciamos un nuevo precio de moneda y la guardamos en la bd
		precio_moneda = Precio_moneda(id_moneda=id_moneda, valor=valor)
		return precio_moneda.save()

	def json(self):
		return {
			'id_moneda': self.id_moneda,
			'fecha': self.fecha,
			'valor': self.valor,
		}
	
	def save(self):
		try:
			db.session.add(self)
			db.session.commit()

			return self
		except:
			return False

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