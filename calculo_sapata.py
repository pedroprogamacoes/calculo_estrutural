$pilar_a  = (isset($_POST['pilar_a'])) ? $_POST['pilar_a'] : '';
$pilar_b  = (isset($_POST['pilar_b'])) ? $_POST['pilar_b'] : '';
$carga  = (isset($_POST['carga'])) ? $_POST['carga'] : '';
$solo  = (isset($_POST['solo'])) ? $_POST['solo'] : '';
$tensão = (isset($_POST['MPa'])) ? $_POST['MPa'] : '';
$nspt  = (isset($_POST['NSPT'])) ? $_POST['NSPT'] : '';
$profundidade  = (isset($_POST['profundidade'])) ? $_POST['profundidade'] : '';
$fck = (isset($_POST['fck'])) ? $_POST['fck'] : '';
$fyk  = (isset($_POST['fyk'])) ? $_POST['fyk'] : '';

#Programa para calculo de fundação em sapata simples

print ('Dados Iniciais de calculo - Dimensionamento de fundação - Sapata simples')
print ('')

pilarA = float(input ('Digite a primeira medida do pilar (cm) - Lado A: '))
pilarB = float(input ('Digite a segunda medida do pilar (cm) - Lado B: '))
carga = float(input ('Qual a carga está atuando sobre esse pilar (kN/cm²)? '))
print ('')

print ('Qual dado do solo prefere inserir?')
print ('1 - Tensão do solo')
print ('2 - NSPT da base de apoio')
solo = int(input ('Resposta: '))

if solo == 1:
    ts = float(input('Digite o valor da tensão do solo (MPa): '))
elif solo == 2:
    nspt = float(input ('Insira o NSPT de base: '))
else:
    print ('Digite um valor correto') 

print ('')
profundidade = input ('Qual a profundidade que a sapata será assentada? ')
print ('')
fck = float(input ('FCK do concreto a ser utilizado (MPa): '))
fyk = float(input ('FYK do aço a ser utilizado (kN/cm²): '))

print ('')
print ('-------------------------------------------------------------------------')
print ('')

# Início dos calculos automáticos

print ('1°) Calculo das dimensões da base')
print ('')

if solo == 1:
    print ('Tensão do solo considerado: ',ts, 'KPa')
    Ab = ((1.05*carga)/(ts*1000))
    print ('Área da base:', round(Ab,2), 'm²')
    print ('')
else:
    ts2 = float((nspt/50)*1000)
    print ('Tensão do solo considerado: ',ts2, 'KPa')
    Ab = ((1.05*carga)/ts2)
    print ('Área da base:', round(Ab,2), 'm²')
    print ('')


if pilarA > pilarB:
    a0b0 = (pilarA/100) - (pilarB/100)
else:
    a0b0 = (pilarB/100) - (pilarA/100)

ladob = ((-a0b0+(((a0b0**2)-4*(-Ab))**(1/2)))/2)
print ('Determinado o lado menor da sapata - Lado B:', round(ladob,3))

ladoa = ladob + a0b0
print ('Determinado o lado maior da sapata - Lado A:', round(ladoa,3))

print ('Valores adotados:')
ladob2 = float(input ('Qual o valor será adotado para o lado B? '))
ladoa2 = float(input ('Qual o valor será adotado para o lado A? '))
print ('')
Ab2 = ladob2*ladoa2
print ('Nova área de base calculada: ', Ab2)
print ('')

verif1 = float(ladoa2/ladob2)
if verif1 <= 2.5:
    result1 = 'Executado com Sucesso!'
else:
    result1 = 'Não conforme, refazer o cálculo'

print ('Verificação condicional de tamanho: ', result1)
print ('lado A / lado B <= 2,5 >>> ', round(verif1,3))
print ('')
print ('-------------------------------------------------------------------------')
print ('')

# Altura útil da peça

print ('2°) Calculo da altura útil -> d')

verifd1 = (((ladoa2*100)-pilarA)/3)
print ('1° Verificação: (a-a0)/3 >>> ', verifd1)
verifd2 = (((ladob2*100)-pilarB)/3)
print ('2° Verificação: (b-b0)/3 >>> ', verifd2)
verifd3 = float((((carga/(((fck*1000)/1.96)*0.85))**(1/2))*1.44)*100)
print ('3° Verificação: (1,44*raiz(carga/(0,85*(fkc/1,96)))) >>> ', round(verifd3,2))
print ('')

# Verificação de qual é o maior

def maiord (verifd1, verifd2, verifd3):
    maxd = verifd1

    if verifd2 > verifd1:
        maxd = verifd2
    if verifd3 > verifd1:
        maxd = verifd3
    return maxd

print ('O valor de "d" é o maior entre as três verificações: ', round((maiord (verifd1, verifd2, verifd3)),2))
print ('')
d = float(input ('Qual o valor a ser adotado para "d" (cm)? '))
print ('')
print ('-------------------------------------------------------------------------')
print ('')

# Calculo da altura da sapata e do rodapé

print ('3°) Calculo da altura da sapata e do rodapé -> h e h1')

h = float(d + 5)
print ('Altura da sapata (h): ',h, 'cm')

h01 = float(d/2)
if h01 > 20:
    h1 = h01
else:
    h1 = 20
print ('Altura do rodapé da sapata (h1): ',h1, 'cm')
print ('')
print ('-------------------------------------------------------------------------')
print ('')

# Calculo dos esforços de tração

print ('4°) Calculo dos esforços de tração')
print ('')

tx = float((carga*((ladoa2*100)-pilarA))/(8*d))
ty = float((carga*((ladob2*100)-pilarB))/(8*d))

print('Esforço de tração no lado A: ',round(tx,2), 'kN')
print('Esforço de tração no lado B: ',round(ty,2), 'kN')
print ('')
print ('-------------------------------------------------------------------------')
print ('')

# Calculo e detalhamento das armaduras

print ('5°) Área de aço')
print ('')

asx = float((1.61*tx)/fyk)
print ('Área de aço do lado X: ', round(asx,2), 'cm')

print ('Opção de "mm" das barras: 5.0 / 6.3 / 8.0 / 10.0 / 12.5 / 16.0')
barrax = input ('Qual o diâmetro da barra a ser utilizada? ')

if barrax == 5.0:
    nx = float(0.196)
elif barrax == 6.3:
    nx = float(0.31)
elif barrax == 8.0:
    nx = float(0.5)
elif barrax == 10.0:
    nx = float(0.785)
elif barrax == 12.5:
    nx = float(1.22)
elif barrax == 16.0:
    nx = float(2.01)
    
sy = (((ladob2*100)-20)/(nx-1))
print ('Espaçamento entre as barras em X: ', sy, 'cm')
print ('')