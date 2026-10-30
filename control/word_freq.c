/**
 * @file word_freq.c
 * @brief Programa que calcula la frecuencia de las palabras de un tamaño dado en un archivo de secuencias de ADN. 
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

/**
 * @brief Función principal del programa.
 * 
 * @param argc Número de argumentos.
 * @param argv Argumentos.
 * 
 * @return 0 si se ha ejecutado correctamente, 1 si ha habido algún error.
 */
int main(int argc, char *argv[]) {
    if (argc != 3) {
        fprintf(stderr, "Uso: %s <nombre del archivo> <tama�o de la palabra>\n", argv[0]);
        return 1;
    }

    const char *fileName = argv[1]; // Nombre del archivo
    int wordSize = atoi(argv[2]); // Tamaño de la palabra
    char *nombreArchivoSalida;
    double procesamientosPorSegundo = 0;

    if (procesarArchivo(fileName, wordSize, &nombreArchivoSalida, &procesamientosPorSegundo) != 0) {
        fprintf(stderr, "Error processing the file.\n");
        return 1;
    }

    printf("%s\n", nombreArchivoSalida);
    printf("%f", procesamientosPorSegundo);

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
    nucleotidos[indice].frecuencia++; // Incrementar la frecuencia
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
