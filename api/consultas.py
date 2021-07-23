#from models import usuarios_año
from flask import Blueprint
from flask import jsonify
from flask import request
from models import db

consultas_bp = Blueprint('consultas_bp', __name__)

#-----------------------------------------------------------------------------------------------------------
#-----------------------------------------------------------------------------------------------------------
def usuarios_año(año):
	try:
		result = db.session.execute('SELECT nombre as "Nombre",  apellido as "Apellido", DATE(fecha_registro) as "Fecha Registro" FROM usuario WHERE EXTRACT(YEAR FROM fecha_registro) ='+str(año))
		return result

	except:
		return False

@consultas_bp.route("/1",methods=['GET'])
def get_usuarios_año():
   año = 2019    #INSERTAR AÑO A ELECCION
   personas = [dict(personas) for personas in usuarios_año(año).fetchall()]
   return jsonify({'personas': personas })
      

#-----------------------------------------------------------------------------------------------------------
#-----------------------------------------------------------------------------------------------------------

def get_cuenta_bancaria(valor):
    try:
	    result = db.session.execute("""SELECT
    numero_cuenta as "Id Cuenta", balance as "Balance"
FROM 
    cuenta_bancaria
WHERE
    balance >= """+str(valor))
	    return result

    except:
	    return False


@consultas_bp.route("/2",methods=['GET'])
def get_cuentas():
   valor = 3000    #INSERTAR VALOR
   cuentas = [dict(cuenta) for cuenta in get_cuenta_bancaria(valor).fetchall()]
   for id_c in cuentas:
      id_c['Balance'] = float(id_c["Balance"])


   return jsonify({'cuentas': cuentas })

#-----------------------------------------------------------------------------------------------------------
#-----------------------------------------------------------------------------------------------------------

def usuarios_pais(pais):
   try:
	   result = db.session.execute("""SELECT
         pais.nombre as "Pais", usuario.nombre as "Nombre", usuario.apellido as "Apellido"
         FROM 
         pais
    INNER JOIN usuario
    ON usuario.pais = pais.cod_pais
WHERE
    pais.nombre = '{}' """.format(pais))
	   return result

   except:
	   return False



@consultas_bp.route("/3",methods=['GET'])
def get_usuarios_pais():
   pais = "Rusia"    #INSERTAR PAIS
   cuentas = [dict(cuenta) for cuenta in usuarios_pais(pais).fetchall()]
   return jsonify({'cuentas': cuentas })


#-----------------------------------------------------------------------------------------------------------
#-----------------------------------------------------------------------------------------------------------

def valor_historico(moneda):
   try:
      result = db.session.execute("""SELECT moneda.nombre as "Nombre",MAX(precio_moneda.valor) as "Valor Máximo"
FROM 
   precio_moneda INNER JOIN moneda
ON precio_moneda.id_moneda = moneda.id
WHERE
   moneda.nombre = '{}'
GROUP BY
   moneda.nombre;""".format(moneda))

      return result

   except:
	   return False

@consultas_bp.route("/4",methods=['GET'])
def get_valor_hist():
   moneda = "Dogecoin"
   valores = [dict(valor) for valor in valor_historico(moneda).fetchall()]
   for dic in valores:
      dic["Valor Máximo"]=float(dic["Valor Máximo"])
   return jsonify({'valores': valores })

#-----------------------------------------------------------------------------------------------------------
#-----------------------------------------------------------------------------------------------------------

def monedas_circulacion(moneda):
      try:
	      result = db.session.execute("""SELECT 
    sigla as "Moneda", SUM(usuario_tiene_moneda.balance) as "Cantidad Total"
FROM 
    moneda, usuario_tiene_moneda
WHERE
    sigla = '{}' AND
    moneda.id = usuario_tiene_moneda.id_moneda
    
GROUP BY sigla""".format(moneda))
	      return result

      except:
	      return False


@consultas_bp.route("/5",methods=['GET'])
def get_monedas():
   sigla_nombre = "RP"    #INSERTAR MONEDA
   monedas = [dict(monedas) for monedas in monedas_circulacion(sigla_nombre).fetchall()]
   for moneda in monedas:
      moneda['Cantidad Total'] = float(moneda['Cantidad Total'])
   return jsonify({'monedas': monedas }) 

"""
CONSULTA 4

SELECT
    moneda.nombre as "Nombre",MAX(precio_moneda.valor) as "Valor Máximo"
FROM 
    precio_moneda INNER JOIN moneda
ON precio_moneda.id_moneda = moneda.id
WHERE
    moneda.nombre = 'Dogecoin'
GROUP BY
    moneda.nombre;
"""
    
"""
CONSULTA 5


SELECT 
    sigla as "Moneda", SUM(usuario_tiene_moneda.balance) as "Cantidad Total"
FROM 
    moneda, usuario_tiene_moneda
WHERE
    sigla = 'DOGE' AND
    moneda.id = usuario_tiene_moneda.id_moneda
    
GROUP BY sigla
"""