from sqlalchemy.sql.expression import null
from models import Usuario
from flask import render_template, Blueprint
from flask import jsonify
from flask import request


usuario_bp = Blueprint('usuario_bp',__name__)

@usuario_bp.route('/', methods=['GET'])
def get_usuarios_all():
	usuarios = [ usuario.json() for usuario in Usuario.query.all() ]
	return jsonify({'usuarios': usuarios })
	#return render_template('usuarios.html', data = usuarios)

@usuario_bp.route("/<id>", methods=["GET"])
def get_usuario(id):
	usuario = Usuario.query.filter_by(id=id).first()
	if usuario is None:
		return jsonify({'mensaje': 'Usuario no existe'}), 404

	return jsonify({'usuario': usuario.json() })

@usuario_bp.route('/', methods=['POST'])
def create_usuario():
	json = request.get_json(force=True)

	if json.get('nombre') is None or json.get('correo') is None or json.get('contraseña') is None or json.get('pais') is None:
		return jsonify({'mensaje': 'El formato está mal'}), 400

	try:
		usuario = Usuario.create(json['nombre'],json['apellido'],json['correo'],json['contraseña'],json['pais'])
	except:
		usuario = Usuario.create(json['nombre'],None,json['correo'],json['contraseña'],json['pais'])

	if usuario == False:
			return jsonify({'mensaje': 'Uno de los valores No Existe'}), 400


	return jsonify({'usuario':usuario.json()})

@usuario_bp.route('/<id>', methods=['PUT'])
def edit_usuario(id):
	usuario = Usuario.query.filter_by(id=id).first()
	if usuario is None:
		return jsonify({'mensaje': 'Usuario no existe'}), 404

	json = request.get_json(force=True)
	if json.get('nombre') is None or json.get('correo') is None or json.get('contraseña') is None or json.get('pais') is None:
		return jsonify({'message': 'Bad request'}), 400

	try:
		usuario.nombre = json['nombre']
		usuario.apellido = json['apellido']
		usuario.correo = json['corre']
		usuario.contraseña = json['contraseña']
		usuario.pais = json['pais']
	except:
		usuario.nombre = json['nombre']
		usuario.apellido = None
		usuario.correo = json['correo']
		usuario.contraseña = json['contraseña']
		usuario.pais = json['pais']

	try:
		usuario.update()
		return jsonify({'usuario': usuario.json() })
	except:
		return jsonify({'message': 'Un parametro no existe en la base de datos'}), 400


@usuario_bp.route('/<id>', methods=['DELETE'])
def delete_usuario(id):
	usuario = Usuario.query.filter_by(id=id).first()
	if usuario is None:
		return jsonify({'mensaje': 'Usuario no existe'}), 404

	usuario.delete()

	return jsonify({'usuario': usuario.json() })