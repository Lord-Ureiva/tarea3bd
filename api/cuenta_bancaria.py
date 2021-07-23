from models import Cuenta_bancaria
from flask import Blueprint
from flask import jsonify
from flask import request

cuenta_bancaria_bp = Blueprint('cuenta_banciaria_bp', __name__)

@cuenta_bancaria_bp.route('/', methods=['GET'])
def get_cuentas_bancarias():
	cuentas_bancaria = [ cuenta_bancaria.json() for cuenta_bancaria in Cuenta_bancaria.query.all() ]
	return jsonify({'cuentas_bancaria': cuentas_bancaria} )
	#return render_template('cuenta_bancaria.html', data = cuentas_bancaria)

@cuenta_bancaria_bp.route('/<numero_cuenta>', methods = ['GET'])
def get_cuenta_bancaria(numero_cuenta):
	cuenta_bancaria = Cuenta_bancaria.query.filter_by(numero_cuenta=numero_cuenta).first()
	if cuenta_bancaria is None:
		return jsonify({'mensaje': 'Cuenta bancaria no existe'}), 404

	return jsonify({'cuenta_bancaria': cuenta_bancaria.json() })

@cuenta_bancaria_bp.route('/', methods=['POST'])
def create_cuenta_bancaria():
	json = request.get_json(force=True)

	if json.get('id_usuario') is None or json.get('balance') is None:
		return jsonify({'mensaje': 'El formato está mal'}), 400


	cuenta_bancaria = Cuenta_bancaria.create(json['id_usuario'],json['balance'])
	if cuenta_bancaria == False:
			return jsonify({'mensaje': 'Uno de los valores No Existe'}), 400

	return jsonify({'cuenta_bancaria':cuenta_bancaria.json()})

@cuenta_bancaria_bp.route('/<numero_cuenta>', methods=['PUT'])
def edit_cuenta_bancaria(numero_cuenta):
	cuenta_bancaria = Cuenta_bancaria.query.filter_by(numero_cuenta=numero_cuenta).first()
	if cuenta_bancaria is None:
		return jsonify({'mensaje': 'Cuenta bancaria no existe'}), 404

	json = request.get_json(force=True)
	if json.get('id_usuario') is None or json.get('balance') is None:
		return jsonify({'message': 'Bad request'}), 400

	cuenta_bancaria.id_usuario = json['id_usuario']
	cuenta_bancaria.balance = json['balance']

	cuenta_bancaria.update()

	return jsonify({'cuenta_bancaria': cuenta_bancaria.json() })

@cuenta_bancaria_bp.route('/<numero_cuenta>', methods=['DELETE'])
def delete_cuenta_bancaria(numero_cuenta):
	cuenta_bancaria = Cuenta_bancaria.query.filter_by(numero_cuenta=numero_cuenta).first()
	if cuenta_bancaria is None:
		return jsonify({'mensaje': 'La cuenta bancaria no existe'}), 404

	cuenta_bancaria.delete()

	return jsonify({'cuenta_bancaria': cuenta_bancaria.json() })

    