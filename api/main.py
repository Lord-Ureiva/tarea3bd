from flask import Flask, render_template, Blueprint
from flask import jsonify
from config import config
from models import db
from flask import request

#BluePrints de los archivos
########################################
from pais import pais_bp
from usuario import usuario_bp
from precio_moneda import p_moneda_bp
from cuenta_bancaria import cuenta_bancaria_bp
from moneda import moneda_bp
from usuario_tiene_moneda import usuario_tiene_moneda_bp
########################################


def create_app(enviroment):
	app = Flask(__name__)
	
	app.register_blueprint(usuario_bp, url_prefix = '/api/usuario')
	app.register_blueprint(pais_bp, url_prefix= '/api/pais')
	app.register_blueprint(p_moneda_bp, url_prefix= '/api/precio_moneda')
	app.register_blueprint(cuenta_bancaria_bp, url_prefix = '/api/cuenta_bancaria')
	app.register_blueprint(moneda_bp, url_prefix= '/api/moneda')
	app.register_blueprint(usuario_tiene_moneda_bp, url_prefix= '/api/usuario_tiene_moneda')


	app.config['JSON_AS_ASCII'] = False
	app.config.from_object(enviroment)
	with app.app_context():
		db.init_app(app)
		db.create_all()
	return app

# Accedemos a la clase config del archivo config.py
enviroment = config['development']
app = create_app(enviroment)

# Endpoint para obtener todos los usuarios


"""
@app.route('/api/v1/users/<id>', methods=['GET'])
def get_user(id):
	user = User.query.filter_by(id=id).first()
	if user is None:
		return jsonify({'message': 'User does not exists'}), 404

	return jsonify({'user': user.json() })

# Endpoint para insertar un usuario en la bd
@app.route('/api/v1/users/', methods=['POST'])
def create_user():
	json = request.get_json(force=True)

	if json.get('username') is None:
		return jsonify({'message': 'El formato está mal'}), 400

	user = User.create(json['username'])

	return jsonify({'user': user.json() })

# Endpoint para actualizar los datos de un usuario en la bd
@app.route('/api/v1/users/<id>', methods=['PUT'])
def update_user(id):
	user = User.query.filter_by(id=id).first()
	if user is None:
		return jsonify({'message': 'User does not exists'}), 404

	json = request.get_json(force=True)
	if json.get('username') is None:
		return jsonify({'message': 'Bad request'}), 400

	user.username = json['username']

	user.update()

	return jsonify({'user': user.json() })

# Endpoint para eliminar el usuario con id igual a <id>
@app.route('/api/v1/users/<id>', methods=['DELETE'])
def delete_user(id):
	user = User.query.filter_by(id=id).first()
	if user is None:
		return jsonify({'message': 'El usuario no existe'}), 404

	user.delete()

	return jsonify({'user': user.json() })
"""
if __name__ == '__main__':
	app.run(debug=True)
