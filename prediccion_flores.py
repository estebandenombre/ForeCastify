import pandas as pd
from sklearn.linear_model import LogisticRegression
from sklearn.model_selection import train_test_split, cross_val_score, StratifiedKFold
from sklearn.metrics import accuracy_score, f1_score, precision_score, recall_score, roc_curve, auc, precision_recall_curve
from sklearn.metrics import confusion_matrix
import seaborn as sns
import matplotlib.pyplot as plt
import shap
import sys
import numpy as np

# Obtener los argumentos pasados desde PHP
variable1 = sys.argv[1]
variable2 = sys.argv[2]

# Realizar alguna operación con las variables
lista_variable1 = variable1.split(", ")

# Cargar los datos desde el archivo CSV
data = pd.read_csv('datos_entrenamiento.csv')
data_prediccion = pd.read_csv('datos_tablaPrediccion.csv')

# Definir las características (X) y el objetivo (y)
X = data[lista_variable1]
y = data[variable2]

# Crear el modelo de Regresión Logística
model = LogisticRegression()

# Utilizar validación cruzada estratificada con 5 divisiones
cv = StratifiedKFold(n_splits=5, shuffle=True, random_state=42)

# Calcular el promedio del rendimiento en validación cruzada
test_sizes = [0.1, 0.2, 0.3, 0.4, 0.5]  # Diferentes tamaños de prueba a probar
mean_scores = []

for test_size in test_sizes:
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=test_size, random_state=42)
    scores = cross_val_score(model, X_train, y_train, cv=cv, scoring='accuracy')
    mean_scores.append(scores.mean())

# Encontrar el tamaño de prueba con el mejor rendimiento promedio
best_test_size = test_sizes[mean_scores.index(max(mean_scores))]

# Dividir los datos en conjuntos de entrenamiento y prueba usando el tamaño óptimo
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=best_test_size, random_state=42)

# Resto del código para entrenar el modelo, realizar predicciones, trazar gráficas, etc.

# Crear y entrenar el modelo de Regresión Logística
model.fit(X_train, y_train)

columnas_nuevos_datos = lista_variable1
nuevos_datos = data_prediccion[columnas_nuevos_datos]

# Obtener las probabilidades de las predicciones en lugar de las etiquetas
y_pred_proba = model.predict_proba(X_test)[:, 1]
prediccion_proba = model.predict_proba(nuevos_datos)[:, 1]

# Calcular las curvas ROC y PR
fpr, tpr, _ = roc_curve(y_test, y_pred_proba)
roc_auc = auc(fpr, tpr)

precision, recall, _ = precision_recall_curve(y_test, y_pred_proba)


# Plot the ROC and PR curves and save as images
plt.figure(figsize=(8, 5))

# Plot ROC curve
plt.subplot(1, 2, 1)
plt.plot(fpr, tpr, color='darkorange', lw=2, label='Curva ROC (área = %0.2f)' % roc_auc)
plt.plot([0, 1], [0, 1], color='navy', lw=2, linestyle='--')
plt.xlim([0.0, 1.0])
plt.ylim([0.0, 1.05])
plt.xlabel('Tasa de Falsos Positivos')
plt.ylabel('Tasa de Verdaderos Positivos')
plt.title('Característica de Operación del Receptor (ROC)')
plt.legend(loc="lower right")
plt.savefig('roc_curve.png')  # Save ROC curve as image

# Plot Precision-Recall curve
plt.subplot(1, 2, 2)
plt.plot(recall, precision, color='darkorange', lw=2, label='Curva Precisión-Recall')
plt.xlabel('Recall')
plt.ylabel('Precisión')
plt.title('Curva Precisión-Recall')
plt.legend(loc="lower left")
plt.savefig('pr_curve.png')  # Save Precision-Recall curve as image



# Realizar la predicción
y_pred = model.predict(X_test)
prediccion = model.predict(nuevos_datos)
accuracy = accuracy_score(y_test, y_pred).round(2)
f1 = f1_score(y_test, y_pred).round(2)
precision = precision_score(y_test, y_pred).round(2)
recall = recall_score(y_test, y_pred).round(2)

# Calcular la matriz de confusión
conf_matrix = confusion_matrix(y_test, y_pred)

# Trazar la matriz de confusión como un mapa de calor
plt.figure(figsize=(6, 6))
sns.heatmap(conf_matrix, annot=True, fmt='d', cmap='Blues')
plt.title('Matriz de Confusión')
plt.xlabel('Predicción')
plt.ylabel('Real')
plt.savefig('confusion_matrix.png')  # Guardar matriz de confusión como imagen
# Trazar la distribución de predicciones vs etiquetas reales
plt.figure(figsize=(8, 5))
sns.histplot(data={'Real': y_test, 'Predicción': y_pred}, bins=2, kde=True)
plt.title('Distribución de Predicciones vs Etiquetas Reales')
plt.xlabel('Valor')
plt.ylabel('Frecuencia')
plt.legend()
plt.savefig('prediction_distribution.png')  # Guardar gráfica de distribución de predicciones

# Calcular la curva de ganancia
gain = tpr

# Trazar la curva de ganancia
plt.figure(figsize=(6, 6))
plt.plot(np.linspace(0, 1, len(gain)), gain, marker='o', color='darkorange', label='Curva de Ganancia')
plt.plot([0, 1], [0, 1], color='navy', lw=2, linestyle='--')
plt.xlabel('Fracción de Muestras')
plt.ylabel('Fracción de Positivos Reales')
plt.title('Curva de Ganancia')
plt.legend(loc="lower right")
plt.savefig('gain_curve.png')  # Guardar curva de ganancia como imagen



# Agregar las métricas al DataFrame de coeficientes
coef_df = pd.DataFrame({'Métrica': ['Accuracy', 'F1', 'Precision', 'Recall'],
                        'Valor': [accuracy, f1, precision, recall]})

# Guardar las métricas en un archivo CSV
metricas_csv = 'metricasModelo.csv'
coef_df.to_csv(metricas_csv, index=False)

# Agregar la columna de predicciones al DataFrame de datos_prediccion
data_prediccion[variable2] = prediccion

# Guardar el DataFrame con las predicciones en un nuevo archivo CSV
data_prediccion.to_csv('predicciones.csv', index=False)

# Obtener los coeficientes del modelo
coefficients = model.coef_[0]

# Crear un DataFrame para visualizar los coeficientes junto con las características
coef_df = pd.DataFrame({'Característica': lista_variable1, 'Coeficiente': coefficients})
coef_df['Coeficiente'] = coef_df['Coeficiente'].abs()
coef_df['Coeficiente'] = coef_df['Coeficiente'].round(2)

# Ordenar los coeficientes en orden descendente para ver las características más importantes primero
coef_df = coef_df.sort_values(by='Coeficiente', ascending=False)

# Calcular las contribuciones de las características utilizando SHAP
explainer = shap.LinearExplainer(model, X_train)
shap_values = explainer.shap_values(X_test)

# Generate explanatory text
explanation = "The trained Logistic Regression model has been used for the variable {}.".format(variable2)
explanation += "\nThe following features have been considered: {}.".format(variable1)
explanation += "\nThe prediction has an accuracy of {} on the test set.".format(accuracy)

# Enviar la explicación a PHP
sys.stdout.write(explanation)
sys.stdout.flush()

# Guardar el DataFrame de coeficientes en un archivo CSV
coef_df.to_csv('resultados.csv', index=False)
