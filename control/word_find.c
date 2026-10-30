/**
 * @file word_find.c
 * @brief Programa que busca un genoma dentro de otro comparado las frecuencias de aparición de las palabras.
 * @author Naiara Gordillo
 * @namespace control
 */
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <math.h>
#include <time.h>

/**
 * @brief Longitud máxima de una línea.
 */
#define MAX_LINE_LENGTH 1024

/**
 * @brief Estructura de un nucleótido.
 */
struct Nucleotidos {
    char *nucleotido;
    int frecuencia;
};

// Prototipos de funciones
unsigned int secuenciaAIndice(const char *secuencia, int wordSize);
void procesarSecuencia(char *secuencia, struct Nucleotidos *nucleotidos, int wordSize, unsigned int max_capacity);
void imprimirFichero(const char *nombreArchivoSalida, struct Nucleotidos *nucleotidos, int numNucleotidos);
int procesarArchivo(const char *fileName, int wordSize, char **nombreArchivoSalida, double *procesamientosPorSegundo);
int grafica(const char *fileName_2, const char *name1, const char *name2, char *nombreArchivoSalida, int wordSize, int puntos, double *procesamientosPorSegundo);
void modificarTitulos(const char *input, char **output);
void graficaPorLineasGnuplot(const int num_puntos, const double y_max, const char *fileName1, const char *fileName2);

/**
 * @brief Función principal del programa.
 * 
 * @param argc Número de argumentos.
 * @param argv Argumentos.
 * 
 * @return 0 si se ha ejecutado correctamente, 1 si ha habido algún error.
 */
int main(int argc, char *argv[]) {
    if (argc != 7) {
        fprintf(stderr, "Uso: %s <nombre del archivo> <nombre del archivo> <tama?o de la palabra> <rango de palabras>\n", argv[0]);
        return 1;
    }

    const char *fileName_1 = argv[1]; // Nombre del fichero de entrada 1
    const char *fileName_2 = argv[2]; // Nombre del fichero de entrada 2
    int wordSize = atoi(argv[3]); // Tamaño de la palabra
    int puntos = atoi(argv[4]); // Número de puntos a graficar
    const char *name1 = argv[5]; // Nombre del archivo 1
    const char *name2 = argv[6]; // Nombre del archivo 2
    char *fileName1;
    char *fileName2;
    char *nombreArchivoSalida;
    double procesamientosPorSegundo1 = 0;
    double procesamientosPorSegundo2 = 0;
    double totalProcesamientosPorSegundo = 0;

    if (procesarArchivo(fileName_1, wordSize, &nombreArchivoSalida, &procesamientosPorSegundo1) != 0) {
        fprintf(stderr, "Error processing the file 1.\n");
        return 1;
    }
    
    modificarTitulos(name1, &fileName1);
    modificarTitulos(name2, &fileName2);
    
    if (grafica(fileName_2, fileName1, fileName2, nombreArchivoSalida, wordSize, puntos, &procesamientosPorSegundo2) != 0) {
        fprintf(stderr, "Error processing the file 1.\n");
        return 1;
    }

	printf("Datos_Grafica_%s_%s.txt\n", fileName1, fileName2);
    printf("WordFind_%s_%s_%d.png\n", fileName1, fileName2, puntos);

    totalProcesamientosPorSegundo = (procesamientosPorSegundo1 + procesamientosPorSegundo2);
    printf("Total de secuencias procesadas por segundo: %.0f\n", totalProcesamientosPorSegundo);

    return 0;
}

/**
 * @brief Crear un archivo de datos para graficar.
 * 
 * @param fileName_2 Nombre del archivo de entrada.
 * @param name1 Nombre del archivo 1.
 * @param name2 Nombre del archivo 2.
 * @param nombreArchivoSalida Nombre del archivo de salida.
 * @param wordSize Tamaño de la palabra.
 * @param puntos Número de puntos a graficar.
 * @param procesamientosPorSegundo Puntero a un double donde se almacenará el número de procesamientos por segundo.
 * 
 * @return 0 si se ha ejecutado correctamente, 1 si ha habido algún error.
 */
int grafica(const char *fileName_2, const char *name1, const char *name2, char *nombreArchivoSalida, int wordSize, int puntos, double *procesamientosPorSegundo) {
    FILE *archivo1, *archivoDatos, *archivo2, * archivoDatos_2;
    clock_t inicio, fin;
	const char *fileName1, *fileName2;
	char linea1[MAX_LINE_LENGTH];
	int capacidad = pow(4, wordSize);
    char *titulo = NULL;
    char letra;
    char *secuencia = malloc((capacidad + 1) * sizeof(char));
	double sumatorio1 = 0.0;
    double duracion;
    int *frecuencias1 = malloc(capacidad * sizeof(int));
    int longitudTitulo = 0;
    char **nomAux = NULL;
    int indexSecuencia = 0;
    int contador = 0;
    int num1;
    int i = 0;
	int j = 0;
    
	fileName1 = nombreArchivoSalida;
	fileName2 = fileName_2;

    archivo1 = fopen(fileName1, "r");
    if (archivo1 == NULL) {
    	fprintf(stderr, "No se pudo abrir el archivov1: %s\n", nombreArchivoSalida);
        free(secuencia);
        return 1;
    }

    // Leer las frecuencias del archivo 1
    int lineCount = 0;
	while (fgets(linea1, MAX_LINE_LENGTH, archivo1) != NULL && i < capacidad) {
    	lineCount++;
    	if (lineCount <= 3) continue;
        if (sscanf(linea1, "%s\t%5d", secuencia, &num1)) {
            if (strcmp(strdup(secuencia), "0") == 0)
            	frecuencias1[i] = 0;
            else
            	frecuencias1[i] = num1;
            i++;
        }
    }
    fclose(archivo1);
    
    archivoDatos = fopen("datos_para_graficar.txt", "w");
	if (archivoDatos == NULL) {
	    fprintf(stderr, "No se pudo abrir el archivo de datos para graficar\n");
	    free(secuencia);
	    if (titulo != NULL) free(titulo);
	    return 1;
	}

    inicio = clock();

	archivo2 = fopen(fileName2, "r");
    if (archivo2 == NULL) {
        fprintf(stderr, "No se pudo abrir el archivo 2: %s\n", fileName_2);
        free(secuencia);
        if (titulo != NULL) free(titulo);
        return 1;
    }
    
    // Leer el título del archivo
    while ((letra = fgetc(archivo2)) != EOF && letra != '\n') {
        longitudTitulo++;
        titulo = (char *)realloc(titulo, longitudTitulo * sizeof(char));
        titulo[longitudTitulo - 1] = letra;
    }
    
    titulo = (char *)realloc(titulo, (longitudTitulo + 1) * sizeof(char));
    titulo[longitudTitulo] = '\0';
    
    // Procesar el archivo
    while ((letra = fgetc(archivo2)) != EOF) {
        if (letra == '\n' || letra == '\0') continue;
        
        if (letra != 'A' && letra != 'C' && letra != 'G' && letra != 'T') {
            indexSecuencia = 0;
            memset(secuencia, 0, sizeof(secuencia));
            continue;
        }

        if (indexSecuencia < wordSize) {
            secuencia[indexSecuencia++] = letra;
        } else {
            memmove(secuencia, secuencia + 1, wordSize - 1);
            secuencia[wordSize - 1] = letra;
        }

        if (indexSecuencia == wordSize) {
            unsigned int indice = secuenciaAIndice(secuencia, wordSize);
			fprintf(archivoDatos, "%s\t%5d\n", secuencia, frecuencias1[indice]);
            contador++;
        }
    }
    fclose(archivo2);
    fclose(archivoDatos);

    fin = clock();

    duracion = (double)(fin - inicio) / CLOCKS_PER_SEC;
    
    if (duracion > 1) {
    	*procesamientosPorSegundo = (double)contador / duracion;
	} else {
	    *procesamientosPorSegundo = (double)contador;
	}
    
    i = 0;
    j = 0;

    archivoDatos = fopen("datos_para_graficar.txt", "r");
    if (archivoDatos == NULL) {
        fprintf(stderr, "No se pudo abrir el archivo de graficas\n");
	    free(secuencia);
        if (titulo != NULL) free(titulo);
        return 1;
    }
    
    // Crear el archivo de datos para graficar
    char archivoDatos_2_name[256];
	sprintf(archivoDatos_2_name, "Datos_Grafica_%s_%s.txt", name1, name2);
	archivoDatos_2 = fopen(archivoDatos_2_name, "w");
    if (archivoDatos_2 == NULL) {
        fprintf(stderr, "No se pudo abrir el archivo de graficas\n");
        free(secuencia);
        if (titulo != NULL) free(titulo);
        return 1;
    }
    
  	if (puntos > contador) puntos = contador; // Si el número de puntos es mayor que el número de palabras, se ajusta
    int base = contador/puntos; // Número de palabras por punto
    double y_max = 0.0; // Valor máximo de 'y' de la gráfica
    
    // Leer las frecuencias del archivo 1
    while (fgets(linea1, MAX_LINE_LENGTH, archivoDatos) != NULL){
        if (sscanf(linea1, "%s\t%5d", secuencia, &num1) == 2) {
            sumatorio1 = sumatorio1 + num1;
            if (j == base - 1) {
            	double sec = sumatorio1 / base;
            	if (sec > y_max) y_max = sec;
            	fprintf(archivoDatos_2, "%d\t%.4f\n", i+1, sec);
                sumatorio1 = 0;
                i++;
                j = 0;
            }
            else {
                j++;
            }
        }
    }
    fclose(archivoDatos);
    fclose(archivoDatos_2);
	free(secuencia);
	if (titulo != NULL) free(titulo);
	
	y_max = y_max + y_max / 10; // Ajustar el rango de la gráfica

    graficaPorLineasGnuplot(puntos, y_max, name1, name2);

	return 0;
}

/**
 * @brief Genrera una grafica de líneas a partir de un archivo de datos.
 * 
 * @param num_puntos Número de puntos a graficar.
 * @param y_max Valor máximo del eje Y.
 * @param fileName1 Nombre del archivo 1.
 * @param fileName2 Nombre del archivo 2.
 */
void graficaPorLineasGnuplot(const int num_puntos, const double y_max, const char *fileName1, const char *fileName2) {	
	int puntos_min = 500; // Número mínimo de puntos
	int divisiones_min = 5; // Número mínimo de divisiones

    // Calcular el número de divisiones
    int num_divisiones = divisiones_min + (int)(sqrt(num_puntos) / 100);
	int intervalo = num_puntos / num_divisiones;
	
    // Calcular el tamaño de la imagen
	int image_width = 1280 + (num_puntos / pow(10, (int)log10(num_puntos)/2));
    int image_height = 720;
    
    // Crear el script de Gnuplot
    FILE *gnuplotScript = fopen("script_gnuplot.gp", "w");
    if (gnuplotScript == NULL) {
        fprintf(stderr, "No se pudo abrir el archivo del script de Gnuplot\n");
        exit(1);
    }
    fprintf(gnuplotScript, "set terminal png size %d,%d\n", image_width, image_height);
    fprintf(gnuplotScript, "set output 'WordFind_%s_%s_%d.png'\n", fileName1, fileName2, num_puntos);
    fprintf(gnuplotScript, "set title ' %s - %s '\n", fileName1, fileName2);
    fprintf(gnuplotScript, "set xlabel '%s'\n", fileName2);
    fprintf(gnuplotScript, "set ylabel 'Frecuencia'\n");
    fprintf(gnuplotScript, "set yrange [0:%f]\n", y_max);
    fprintf(gnuplotScript, "set xrange [0:%d]\n", num_puntos);
    fprintf(gnuplotScript, "set xtics %d\n", intervalo);
    fprintf(gnuplotScript, "set mxtics 5\n");
    fprintf(gnuplotScript, "plot 'Datos_Grafica_%s_%s.txt' using 1:2 with line notitle\n", fileName1, fileName2);
    fclose(gnuplotScript);
    
    system("gnuplot script_gnuplot.gp");
}

/**
 * @brief Modifica los títulos de los archivos.
 * 
 * Extrae el nombre del archivo a partir de su ruta y elimina la extensión.
 * 
 * @param input Puntero a la cadena que representa el nombre del archivo de entrada.
 * @param output Doble puntero a char donde se almacena el nombre del archivo de salida.
 */
void modificarTitulos(const char *input, char **output) {
    const char *extension = ".gz"; // Extensi�n que se eliminar�
    size_t input_len = strlen(input); // Longitud del nombre del archivo de entrada
    size_t ext_len = strlen(extension); // Longitud de la extensi�n

    // Comprobar si el nombre del archivo termina con la extensi�n .gz
    if (input_len > ext_len && strcmp(input + input_len - ext_len, extension) == 0) {
        // Asignar memoria para el nuevo nombre, excluyendo la extensi�n
        *output = malloc((input_len - ext_len + 1) * sizeof(char)); // +1 para el terminador nulo
        if (*output == NULL) {
            fprintf(stderr, "No se pudo asignar memoria para el nombre del archivo de salida.\n");
            exit(1);
        }
        // Copiar el nombre del archivo sin la extensi�n
        strncpy(*output, input, input_len - ext_len); // Copia el nombre del archivo
        (*output)[input_len - ext_len] = '\0'; // Agrega el terminador de cadena
    } else {
        // Asignar memoria para el nombre original
        *output = malloc((input_len + 1) * sizeof(char)); // +1 para el terminador nulo
        if (*output == NULL) {
            fprintf(stderr, "No se pudo asignar memoria para el nombre del archivo de salida.\n");
            exit(1);
        }
        strcpy(*output, input); // Copia el nombre del archivo original
    }
}

/**
 * @brief Procesa un archivo FASTA y genera un archivo de texto con las frecuencias de aparición de cada subsecuencia de longitud wordSize.
 * 
 * Esta función lee un archivo en formato FASTA, extrae todas las subsecuencias de longitud wordSize, y calcula la frecuencia de aparición de 
 * cada una. Los resultados se almacenan en un archivo de salida en formato .txt, cuyo nombre se devuelve a través del puntero proporcionado.
 * 
 * @param fileName Nombre del archivo FASTA de entrada.
 * @param wordSize Tamaño de la subsecuencia (palabra) a utilizar para calcular las frecuencias.
 * @param nombreArchivoSalida Puntero a un puntero de char donde se almacenará el nombre del archivo de salida.
 * @param procesamientosPorSegundo Puntero a un double donde se almacenará el número de procesamientos por segundo.
 * 
 * @return 0 si la función se ha ejecutado correctamente, 1 si ha ocurrido algún error.
 */
int procesarArchivo(const char *fileName, int wordSize, char **nombreArchivoSalida, double *procesamientosPorSegundo) {
    FILE *archivoIN;
    clock_t inicio, fin;
    char *secuencia = malloc((wordSize + 1) * sizeof(char));
    char *titulo = NULL;
    char letra;
    double duracion;
    int indexSecuencia = 0;
    int longitudTitulo = 0;
    int sumaTotalFrecuencias = 0;
    int i;
    unsigned int max_capacity = pow(4, wordSize);

    // Inicializar la estructura de nucleótidos
    struct Nucleotidos *nucleotidos = malloc(max_capacity * sizeof(struct Nucleotidos));
    if (nucleotidos == NULL) {
        fprintf(stderr, "No se pudo asignar memoria inicial para los nucleotidos.\n");
        free(secuencia);
        return 1;
    }

    for (i = 0; i < max_capacity; i++) {
        nucleotidos[i].frecuencia = 0;
        nucleotidos[i].nucleotido = malloc((wordSize + 1) * sizeof(char));
        nucleotidos[i].nucleotido[0] = '\0';
    }

    inicio = clock();

    archivoIN = fopen(fileName, "r");
    if (archivoIN == NULL) {
        fprintf(stderr, "No se pudo abrir el archivo.\n");
        free(secuencia);
        for (i = 0; i < max_capacity; i++) {
            free(nucleotidos[i].nucleotido);
        }
        free(nucleotidos);
        return 1;
    }

    // Leer el título del archivo
    while ((letra = fgetc(archivoIN)) != EOF && letra != '\n') {
        longitudTitulo++;
        titulo = (char *)realloc(titulo, longitudTitulo * sizeof(char));
        titulo[longitudTitulo - 1] = letra;
    }

    titulo = (char *)realloc(titulo, (longitudTitulo + 1) * sizeof(char));
    titulo[longitudTitulo] = '\0';

    // Recorrer el archivo FASTA
    while ((letra = fgetc(archivoIN)) != EOF) {
        if (letra == '\n' || letra == '\0') continue;

        if (letra == 'N') {
            // Reiniciar la secuencia cuando se encuentra una 'N'
            indexSecuencia = 0;
            memset(secuencia, 0, (wordSize + 1) * sizeof(char));
            continue;
        }

        // Procesar la secuencia
        if (indexSecuencia < wordSize) {
            secuencia[indexSecuencia++] = letra;
            if (indexSecuencia == wordSize) {
                procesarSecuencia(secuencia, nucleotidos, wordSize, max_capacity);
            }
        } else {
            memmove(secuencia, secuencia + 1, wordSize - 1);
            secuencia[wordSize - 1] = letra;
            procesarSecuencia(secuencia, nucleotidos, wordSize, max_capacity);
        }
    }

    fclose(archivoIN);

    fin = clock();

    duracion = (double)(fin - inicio) / CLOCKS_PER_SEC;
    
    for (i = 0; i < max_capacity; i++) {
        sumaTotalFrecuencias += nucleotidos[i].frecuencia;
    }
    
    if (duracion > 1) {
    	*procesamientosPorSegundo = (double)sumaTotalFrecuencias / duracion;
	} else {
	    *procesamientosPorSegundo = (double)sumaTotalFrecuencias;
	}

    // Imprimir el archivo de salida
    memmove(titulo, titulo + 1, longitudTitulo);
    longitudTitulo--;
    titulo[longitudTitulo] = '\0'; 
    
    char *espacio = strchr(titulo, ' ');
    int tituloLongitud;
    
	if (espacio != NULL) {
        tituloLongitud = espacio - titulo;
    } else {
        tituloLongitud = strlen(titulo); 
    }

    const char *carpetaDestino = "../files/";
    *nombreArchivoSalida = malloc((tituloLongitud + 29) * sizeof(char));
    if (*nombreArchivoSalida == NULL) {
        fprintf(stderr, "No se pudo asignar memoria para el nombre del archivo de salida.\n");
        return 1;
    }
    snprintf(*nombreArchivoSalida, tituloLongitud + 29, "%s%.*s_k=%d_Freq.txt", carpetaDestino, tituloLongitud, titulo, wordSize);
    
    imprimirFichero(*nombreArchivoSalida, nucleotidos, max_capacity);

    free(secuencia);
    for (i = 0; i < max_capacity; i++) {
        free(nucleotidos[i].nucleotido);
    }
    free(nucleotidos);
    free(titulo);

    return 0;
}

/**
 * @brief Convierte una secuencia en un índice.
 * 
 * Toma una secuencia de nucleótidos y la convierte en un índice numérico que representa su posición 
 * dentro del genoma. Esta función es útil para realizar búsquedas rápidas en grandes secuencias.
 * 
 * @param secuencia Puntero a la secuencia de nucleótidos a convertir.
 * @param wordSize Tamaño de la palabra (número de nucleótidos en la secuencia).
 * 
 * @return unsigned int Índice generado a partir de la secuencia.
 */
unsigned int secuenciaAIndice(const char *secuencia, int wordSize) {
    unsigned int indice = 0;
    int i;
    for (i = 0; i < wordSize; i++) {
        indice <<= 2;
        switch (secuencia[i]) {
            case 'A': // 00
                break;
            case 'C': // 01
                indice |= 1;
                break;
            case 'G': // 10
                indice |= 2;
                break;
            case 'T': // 11
                indice |= 3;
                break;
            default:
                printf("%s\n", secuencia);
                printf("Caracter inesperado encontrado\n");
                break;
        }
    }
    return indice;
}

/**
 * @brief Procesa una secuencia y actualiza la estructura de nucleótidos.
 * 
 * @param secuencia Puntero a la secuencia.
 * @param nucleotidos Puntero a la estructura de nucleótidos.
 * @param wordSize Tamaño de la palabra.
 * @param max_capacity Capacidad máxima.
 */
void procesarSecuencia(char *secuencia, struct Nucleotidos *nucleotidos, int wordSize, unsigned int max_capacity) {
    unsigned int indice = secuenciaAIndice(secuencia, wordSize);
    // Si el nucleótido no está en la estructura, se agrega
    if (nucleotidos[indice].frecuencia == 0) {
        strncpy(nucleotidos[indice].nucleotido, secuencia, wordSize);
        nucleotidos[indice].nucleotido[wordSize] = '\0';
    }
    nucleotidos[indice].frecuencia++; // Se incrementa la frecuencia
}

/**
 * @brief Imprime las frecuencias de las palabras en un archivo.
 * 
 * @param nombreArchivoSalida Nombre del archivo de salida.
 * @param nucleotidos Puntero a la estructura de nucleótidos.
 * @param numNucleotidos Número de nucleótidos.
 */
void imprimirFichero(const char *nombreArchivoSalida, struct Nucleotidos *nucleotidos, int numNucleotidos) {
    FILE *archivoOUT = fopen(nombreArchivoSalida, "w");
    int i;

    if (archivoOUT == NULL) {
        fprintf(stderr, "No se pudo abrir el archivo de salida.\n");
        exit(1);
    }

    fprintf(archivoOUT, "==========================\n");
    fprintf(archivoOUT, "Word\t\tFrequency\n");
    fprintf(archivoOUT, "__________________________\n");

    for (i = 0; i < numNucleotidos; i++) {
        fprintf(archivoOUT, "%s\t\t%5d\n", nucleotidos[i].nucleotido, nucleotidos[i].frecuencia);
    }

    fclose(archivoOUT);
}
