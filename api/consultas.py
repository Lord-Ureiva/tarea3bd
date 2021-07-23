from models import Cuenta_bancaria
from flask import Blueprint, render_template
from flask import jsonify
from flask import request

consultas_bp = Blueprint('consultas_bp', __name__)


