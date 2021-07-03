from datetime import datetime
from flask_sqlalchemy import SQLAlchemy
# Importamos para realizar consultas personalizadas
from sqlalchemy import text

db = SQLAlchemy()

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