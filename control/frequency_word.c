/**
 * @file frequency_word.c
 * @brief Programa que compara dos archivos de frecuencias de palabras y genera una gráfica de la comparación en frecuencias absolutas.
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
int frecuenciasAbsolutas(char *nombreArchivoSalida_1, char *nombreArchivoSalida_2, char **name, int wordSize);

/**
 * @brief Función principal del programa.
 * 
 * @param argc Número de argumentos.
 * @param argv Argumentos.
 * 
 * @return 0 si se ha ejecutado correctamente, 1 si ha habido algún error.
 */
int main(int argc, char *argv[]) {
    if (argc != 4) {
        fprintf(stderr, "Uso: %s <nombre del archivo> <nombre del archivo> <tama�o de la palabra>\n", argv[0]);
        return 1;
    }

    const char *fileName_1 = argv[1]; // Nombre del archivo 1
    const char *fileName_2 = argv[2]; // Nombre del archivo 2
    int wordSize = atoi(argv[3]); // Tamaño de la palabra
    char *nombreArchivoSalida_1;
    char *nombreArchivoSalida_2;
    char *name;
    double procesamientosPorSegundo1 = 0;
    double procesamientosPorSegundo2 = 0;
    double totalProcesamientosPorSegundo = 0;

    if (procesarArchivo(fileName_1, wordSize, &nombreArchivoSalida_1, &procesamientosPorSegundo1) != 0) {
    	fprintf(stderr, "Error processing the file 1.\n");
    	return 1;
	}
	
	if (procesarArchivo(fileName_2, wordSize, &nombreArchivoSalida_2, &procesamientosPorSegundo2) != 0) {
	    fprintf(stderr, "Error processing the file 2.\n");
	    return 1;
	}
	
	if (frecuenciasAbsolutas(nombreArchivoSalida_1, nombreArchivoSalida_2, &name, wordSize) != 0) {
	    fprintf(stderr, "Error comparar distancias.\n");
	    return 1;
	}
	
	printf("%s\n", name);

    totalProcesamientosPorSegundo = (procesamientosPorSegundo1 + procesamientosPorSegundo2);
    printf("Total de secuencias procesadas por segundo: %.0f\n", totalProcesamientosPorSegundo);
	
	return 0;
}

/**
 * @brief A partir de dos ficheros genera un archivo con las frecuencias absolutas de cada uno.
 * 
 * @param nombreArchivoSalida_1 Nombre del archivo de salida 1.
 * @param nombreArchivoSalida_2 Nombre del archivo de salida 2.
 * @param name Puntero a un puntero de char donde se almacenará el nombre del archivo de salida.
 * @param wordSize Tamaño de la palabra.
 * 
 * @return 0 si se ha ejecutado correctamente, 1 si ha habido algún error.
 */
int frecuenciasAbsolutas(char *nombreArchivoSalida_1, char *nombreArchivoSalida_2, char **name, int wordSize) {
    FILE *archivo1, *archivo2, *archivoFrecuencias;
    const char *fileName1, *fileName2;
    int capacidad = pow(4, wordSize);
    char *secuencia1 = malloc((capacidad + 1) * sizeof(char)); 
    char *secuencia2 = malloc((capacidad + 1) * sizeof(char)); 
    char linea1[MAX_LINE_LENGTH], linea2[MAX_LINE_LENGTH];
    int *sec1 = malloc(capacidad * sizeof(int));
    int *sec2 = malloc(capacidad * sizeof(int));
    int sumatorio1 = 0;
    int sumatorio2 = 0;
    int num1, num2, i;
    int j = 0;
    float max = 0.0;

    fileName1 = nombreArchivoSalida_1;
    fileName2 = nombreArchivoSalida_2;

    archivo1 = fopen(fileName1, "r");
    if (archivo1 == NULL) {
        fprintf(stderr, "No se pudo abrir el archivo1.txt\n");
        exit(1);
    }

    archivo2 = fopen(fileName2, "r");
    if (archivo2 == NULL) {
        fprintf(stderr, "No se pudo abrir el archivo2.txt\n");
        fclose(archivo1);
        exit(1);
    }

    // Leer los archivos de frecuencias y almacenarlas en un array
    int lineCount = 0;
    while ((fgets(linea1, MAX_LINE_LENGTH, archivo1)) != NULL &&
           (fgets(linea2, MAX_LINE_LENGTH, archivo2)) != NULL) {
        lineCount++;
        if (lineCount <= 3) continue;
        if (sscanf(linea1, "%s\t%5d", secuencia1, &num1) &&
            sscanf(linea2, "%s\t%5d", secuencia2, &num2)) {
            if (strcmp(secuencia1, "0") == 0)
                num1 = 0;
            if (strcmp(secuencia2, "0") == 0)
                num2 = 0;

            sec1[j] = num1;
            sec2[j] = num2;
            j++;

            sumatorio1 = sumatorio1 + num1;
            sumatorio2 = sumatorio2 + num2;
        }
    }
    
    fclose(archivo1);
    fclose(archivo2);
    
    // Verificar que no esten vacios
    if (sec1 == NULL || sec2 == NULL) {
    	fprintf(stderr, "Error al asignar memoria para sec1 o sec2\n");
    	return 1;
	}
    
    archivoFrecuencias = fopen("frecuencias_absolutas.txt", "w");
    if (archivoFrecuencias == NULL) {
        fprintf(stderr, "No se pudo abrir el archivo de frecuencias\n");
        return 1;
    }
    
    // Calcular el factor de escala
    float factorEscala = (float)sumatorio2 / sumatorio1;
    
    for(i = 0; i < capacidad; i++) {
        fprintf(archivoFrecuencias, "%.4f\t%d\n", sec1[i] * factorEscala, sec2[i]);
        
        if ((sec1[i] * factorEscala) > sec2[i]) {
            if ((sec1[i] * factorEscala) > max)
                max = (sec1[i] * factorEscala);
        }
        
        if (sec2[i] > (sec1[i] * factorEscala)) {
            if (sec2[i] > max)
                max = sec2[i];
        }
    }
    
    fclose(archivoFrecuencias);
    
    max = max + max / 10; // Ajustar el rango de la gráfica
    
    *name = malloc(50 * sizeof(char));
	sprintf(*name, "frecuencias_absolutas_%.2f.txt", max);
    
    return 0;
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
    nucleotidos[indice].frecuencia++; // Incrementa la frecuencia
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
    fprintf(archivoOUT, "Word\tFrequency\n");
    fprintf(archivoOUT, "__________________________\n");

    for (i = 0; i < numNucleotidos; i++) {
        fprintf(archivoOUT, "%s\t%5d\n", nucleotidos[i].nucleotido, nucleotidos[i].frecuencia);
    }

    fclose(archivoOUT);
}
