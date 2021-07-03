from flask import Flask
from flask import jsonify
from config import config
from models import db
from models import User
from models import Task
from flask import request


def create_app(enviroment):
	app = Flask(__name__)
	app.config.from_object(enviroment)
	with app.app_context():
		db.init_app(app)
		db.create_all()
	return app


enviroment = config['development']
app = create_app(enviroment)

# Se obtienen todos los usuarios
@app.route('/api/v1/users', methods=['GET'])
def get_users():
	users = [ user.json() for user in User.query.all() ] 
	return jsonify({'users': users })

@app.route('/api/v1/users/<id>', methods=['GET'])
def get_user(id):
	user = User.query.filter_by(id=id).first()
	if user is None:
		return jsonify({'message': 'El usuario no existe'}), 404

	return jsonify({'user': user.json() })

@app.route('/api/v1/users/', methods=['POST'])
def create_user():
	json = request.get_json(force=True)

	if json.get('username') is None:
		return jsonify({'message': 'El formato está mal'}), 400

	user = User.create(json['username'])

	return jsonify({'user': user.json() })

@app.route('/api/v1/users/<id>', methods=['PUT'])
def update_user(id):
	user = User.query.filter_by(id=id).first()
	if user is None:
		return jsonify({'message': 'El usuario no existe'}), 404
	json = request.get_json(force=True)
	if json.get('username') is None:
		return jsonify({'message': 'Solicitud Incorrecta'}), 400
	user.username = json['username']
	user.update()
	return jsonify({'user': user.json() })

@app.route('/api/v1/users/<id>', methods=['DELETE'])
def delete_user(id):
	user = User.query.filter_by(id=id).first()
	if user is None:
		return jsonify({'message': 'El usuario no existe'}), 404

	user.delete()

	return jsonify({'user': user.json() })

@app.route('/api/v1/tasks/', methods=['POST'])
def create_task():
	json = request.get_json(force=True)

	if json.get('description') is None:
		return jsonify({'message': 'El formato está mal'}), 400

	task = Task.create(json['description'],json['user_id'])

	return jsonify({'task': task.json() })

@app.route('/api/v1/tasks', methods=['GET'])
def get_tasks():
	tasks = [ task.json() for task in Task.query.all() ] 
	return jsonify({'tasks': tasks })

@app.route('/api/v1/tasks/max_id/<max_id>', methods=['GET'])
def get_custom(max_id):
	tasks = [dict(task) for task in Task.custom(max_id=max_id).fetchall()]
	return jsonify({'tasks': tasks })


@app.route('/api/v1/join/', methods=['GET'])
def get_tasks_users():
	tasks_users = [ {**(user.json()),**(task.json())} for user,task in db.session.query(User,Task).join(Task, User.id == Task.user_id).all()]
	return jsonify({'tasks_users': tasks_users })

@app.route('/api/v1/join/<id>', methods=['GET'])
def get_tasks_user(id):
	tasks = [ {**(user.json()),**(task.json())} for user,task in db.session.query(User,Task).join(Task, User.id == Task.user_id).filter(User.id == id).all()]
	return jsonify({'tasks': tasks })

if __name__ == '__main__':
	app.run(debug=True)