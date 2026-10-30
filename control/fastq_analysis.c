/**
 * @file fastq_analysis.c
 * @brief Programa que compara distancias directas e inversas a un archivo MILTIFASTA de un archivo FASTQ y genera un archivo de salida con las distancias.
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
 * @brief Número máximo de directorios.
 */
#define MAX_DIRECTORIOS 1000

/**
 * @brief Estructura de un nucleótido.
 */
struct Nucleotidos {
    char *nucleotido;
    int frecuencia;
};

/**
 * @brief Estructura de un directorio multifatsa.
 */
struct Directorio {
    char *titulo;
    struct Nucleotidos *nucleotidos;
};

/**
 * @brief Estructura de una etiqueta fastq.
 */
struct Etiqueta {
    char *titulo;
    int *num_directorio;
    int num_palabras;
    double distancia_min;
    int *directorio_min;
    int num_directorios_min;
};

// Prototipos de funciones
struct Directorio* procesarMultifasta(const char *fileName, int wordSize, int *numDirectorios, double *procesamientosPorSegundo);
struct Etiqueta* procesarFastq(const char *fileName, const char *outputName1, const char *outputName2, int wordSize, char **nombreArchivoSalida, const struct Directorio *directorios, int numDirectorios, int *numEtiqueta, float umbral, int mayorMenor, double *procesamientosPorSegundo);
struct Etiqueta* inversaComplementaria(const char *fileName, const char *outputName1, const char *outputName2, int wordSize, char **nombreArchivoSalida, const struct Directorio *directorios, int numDirectorios, const struct Etiqueta *etiquetas_1, int numEtiquetas_1, float umbral, int mayorMenor, double *procesamientosPorSegundo);
int compararSecuenciasDirectaInversa(const struct Etiqueta *etiquetas_1, const struct Etiqueta *etiquetas_2, const struct Directorio *directorios, int numEtiquetas, int numDirectorios, char **nombreArchivoSalida, const char *outputName1, const char *outputName2, float umbral, int mayorMenor);
unsigned int secuenciaAIndice(const char *secuencia, int wordSize);
unsigned int secuenciaAIndiceInverso(const char *secuencia, int wordSize);
void invertirEtiquetas(struct Etiqueta* etiquetas, int numEtiquetas);
void procesarSecuencia(char *secuencia, struct Nucleotidos *nucleotidos, int wordSize, unsigned int max_capacity);
void imprimirFichero(const char *nombreArchivoSalida, const struct Etiqueta *etiquetas, const struct Directorio *directorios, int numEtiquetas, int numDirectorios, float umbral, int mayorMenor);
void graficaPorBarrasGnuplot(const struct Etiqueta *etiquetas, const struct Directorio *directorios, int numEtiquetas, int numDirectorios, const char *nombreArchivoSalida, const char *outputName1);
void modicarTitulos(const char *input, char **output);

/**
 * @brief Función principal del programa.
 * 
 * @param argc Número de argumentos.
 * @param argv Argumentos.
 * 
 * @return 0 si se ha ejecutado correctamente, 1 si ha habido algún error.
 */
int main(int argc, char *argv[]) {
	if (argc != 8) {
        fprintf(stderr, "Uso: %s <input1> <input2> <wordSize> <umbral>\n", argv[0]);
        return 1;
    }

    const char *fileName_1 = argv[1]; // MULTIFASTA
    const char *fileName_2 = argv[2]; // FASTQ
    int wordSize = atoi(argv[3]); // Tamaño de la palabra
    const char *outputName1 = argv[4]; // Nombre del archivo 1
    const char *outputName2 = argv[5]; // Nombre del archivo 2
    char *endptr;
    float umbral = strtof(argv[6], &endptr); // Umbral de distancia
    if (endptr == argv[6]) {
        fprintf(stderr, "Error: '%s' no es un n�mero v�lido para umbral.\n", argv[6]);
        return 1;
    }
    int mayorMenor = atoi(argv[7]); // Indicador de mayor o menor
    
    char *name1, *name2, *name3; // Nombres de los archivos de salida
    int numDirectorios = 0; // Número de directorios
    int numEtiquetas = 0; // Número de etiquetas
    double procesamientosPorSegundoMultifasta = 0.0;
    double procesamientosPorSegundoFastq = 0.0;
    double procesamientosPorSegundoInversa = 0.0;
    double procesamientosPorSegundoTotal = 0.0;
    
    struct Directorio *directorios = procesarMultifasta(fileName_1, wordSize, &numDirectorios, &procesamientosPorSegundoMultifasta);
    if (directorios == NULL) {
        fprintf(stderr, "Error processing the file.\n");
        return 1;
    }
    
    struct Etiqueta *etiquetas_1 = procesarFastq(fileName_2, outputName1, outputName2, wordSize, &name1, directorios, numDirectorios, &numEtiquetas, umbral, mayorMenor, &procesamientosPorSegundoFastq);
    if (etiquetas_1 == NULL) {
        fprintf(stderr, "Error processing the file.\n");
        return 1;
    }
    
	printf("%s.txt\n", name1);
	printf("%s_%.2f.txt\n", name1, umbral);
    
    struct Etiqueta *etiquetas_2 = inversaComplementaria(fileName_2, outputName1, outputName2, wordSize, &name2, directorios, numDirectorios, etiquetas_1, numEtiquetas, umbral, mayorMenor, &procesamientosPorSegundoInversa);
    if (etiquetas_2 == NULL) {
        fprintf(stderr, "Error processing the file.\n");
        return 1;
    }
    
    printf("%s.txt\n", name2);
    printf("%s_%.2f.txt\n", name2, umbral);
    
    if (compararSecuenciasDirectaInversa(etiquetas_1, etiquetas_2, directorios, numEtiquetas, numDirectorios, &name3, outputName1, outputName2, umbral, mayorMenor) != 0) {
        fprintf(stderr, "Error sumando las secuencias.\n");
        return 1;
    }
    
    printf("%s.txt\n", name3);
    printf("%s_%.2f.txt\n", name3, umbral);
    
    printf("%s\n", name1);
    printf("%s\n", name2);
    printf("%s\n", name3);

    procesamientosPorSegundoTotal = (procesamientosPorSegundoMultifasta + procesamientosPorSegundoFastq + procesamientosPorSegundoInversa);
    printf("Total de secuencias procesadas por segundo: %.0f\n", procesamientosPorSegundoTotal);
    
    if (etiquetas_1) free(etiquetas_1);
	if (etiquetas_2) free(etiquetas_2);
	if (directorios) free(directorios);
	if (name1) free(name1);
	if (name2) free(name2);
	if (name3) free(name3);

    return 0;
}

/**
 * @brief Compara las secuencias directa e inversa y genera una estructura de etiquetas con las distancias mínimas.
 * 
 * Esta función toma las secuencias procesadas (directa e inversa) y compara sus distancias utilizando 
 * los directorios generados previamente. La distancia menor de cada etiquera se almacenarán 
 * en una estructura de etiquetas.
 * 
 * @param etiquetas_1 Puntero a la estructura de etiquetas generada por procesarFastq (para la secuencia directa).
 * @param etiquetas_2 Puntero a la estructura de etiquetas generada por inversaComplementaria (para la secuencia inversa).
 * @param directorios Puntero a la estructura de directorios (contiene los datos del archivo MULTIFASTA).
 * @param numEtiquetas Número total de etiquetas (igual para ambas estructuras de etiquetas).
 * @param numDirectorios Número total de directorios.
 * @param nombreArchivoSalida Puntero a un puntero de char donde se almacenará el nombre del archivo de salida.
 * @param outputName1 Nombre del primer archivo de salida.
 * @param outputName2 Nombre del segundo archivo de salida.
 * @param umbral Umbral para el procesamiento.
 * @param mayorMenor Indicador de mayor o menor.
 * 
 * @return int Retorna 0 si la comparación fue exitosa. Retorna -1 en caso de error.
 */
int compararSecuenciasDirectaInversa(const struct Etiqueta *etiquetas_1, const struct Etiqueta *etiquetas_2, const struct Directorio *directorios, int numEtiquetas, int numDirectorios, char **nombreArchivoSalida, const char *outputName1, const char *outputName2, float umbral, int mayorMenor) {
	double minimo;
	int i, j;
	
	struct Etiqueta* etiquetas = malloc(MAX_DIRECTORIOS * sizeof(struct Etiqueta));
	if (etiquetas == NULL) {
        fprintf(stderr, "Error: No se pudo asignar memoria.\n");
        exit(1);
    }
    
    // Comparar las distancias mínimas de las secuencias directa e inversa
	for (i = 0; i < numEtiquetas; i++) {
		etiquetas[i].directorio_min = malloc(numDirectorios * sizeof(int));
        // Comprobar si se ha asignado memoria correctamente
		if (etiquetas[i].directorio_min == NULL) {
    		fprintf(stderr, "Error al asignar memoria para directorio_min en la etiqueta %d\n", i);
    		return -1;
		}
		etiquetas[i].titulo = strdup(etiquetas_1[i].titulo);
		
        // Comparar las distancias mínimas
		if (etiquetas_1[i].distancia_min < etiquetas_2[i].distancia_min){
			minimo = etiquetas_1[i].distancia_min;
			etiquetas[i].distancia_min = minimo;
			etiquetas[i].num_directorios_min = etiquetas_1[i].num_directorios_min;
			
			for (j = 0; j < etiquetas_1[i].num_directorios_min; j++) {
	            etiquetas[i].directorio_min[j] = etiquetas_1[i].directorio_min[j];
			}
		} else if (etiquetas_1[i].distancia_min > etiquetas_2[i].distancia_min) {
			minimo = etiquetas_2[i].distancia_min;
			etiquetas[i].distancia_min = minimo;
			etiquetas[i].num_directorios_min = etiquetas_2[i].num_directorios_min;
			
			for (j = 0; j < etiquetas_2[i].num_directorios_min; j++) {
	            etiquetas[i].directorio_min[j] = etiquetas_2[i].directorio_min[j];
			}
		} else {
			etiquetas[i].num_directorios_min = etiquetas_1[i].num_directorios_min;
			for (j = 0; j < etiquetas_1[i].num_directorios_min; j++) {
	            etiquetas[i].directorio_min[j] = etiquetas_1[i].directorio_min[j];
			}
		}
    }

    // Generar el nombre del archivo de salida
    *nombreArchivoSalida = malloc(strlen("Comparacion_") + strlen(outputName1) + strlen(outputName2) + 1);
    if (*nombreArchivoSalida == NULL) {
        fprintf(stderr, "Error: No se pudo asignar memoria para el nombre del archivo de salida.\n");
        exit(1);
    }
    sprintf(*nombreArchivoSalida, "Comparacion_%s_%s", outputName1, outputName2);

    imprimirFichero(*nombreArchivoSalida, etiquetas, directorios, numEtiquetas, numDirectorios, umbral, mayorMenor);
    graficaPorBarrasGnuplot(etiquetas, directorios, numEtiquetas, numDirectorios, *nombreArchivoSalida, outputName1);
    
     for (i = 0; i < numEtiquetas; i++) {
        free(etiquetas[i].directorio_min);
    }
    
    free(etiquetas);
    
    return 0;
}

/**
 * @brief Genera la inversa complementaria de un archivo FASTQ y genera una estructura de etiquetas.
 * 
 * Esta función toma un archivo FASTQ y genera su inversa complementaria. Luego, compara las distancias
 * de las secuencias directa e inversa utilizando los directorios generados previamente.
 * 
 * @param fileName Nombre del archivo FASTQ.
 * @param outputName1 Nombre del primer archivo de salida.
 * @param outputName2 Nombre del segundo archivo de salida.
 * @param wordSize Tamaño de la palabra.
 * @param nombreArchivoSalida Puntero a un puntero de char donde se almacenará el nombre del archivo de salida.
 * @param directorios Puntero a la estructura de directorios.
 * @param numDirectorios Número de directorios.
 * @param etiquetas_1 Puntero a la estructura de etiquetas generada por procesarFastq.
 * @param numEtiquetas_1 Número de etiquetas generadas por procesarFastq.
 * @param umbral Umbral para el procesamiento.
 * @param mayorMenor Indicador de mayor o menor.
 * @param procesamientosPorSegundo Puntero a un double donde se almacenará el número de procesamientos por segundo.
 * 
 * @return struct Etiqueta* Puntero a la estructura de etiquetas generada.
 */
struct Etiqueta* inversaComplementaria(const char *fileName, const char *outputName1, const char *outputName2, int wordSize, char **nombreArchivoSalida, const struct Directorio *directorios, int numDirectorios, const struct Etiqueta *etiquetas_1, int numEtiquetas_1, float umbral, int mayorMenor, double *procesamientosPorSegundo) {
    FILE *archivoIN, *archivoDatos;
    clock_t inicio, fin;
    char *secuencia = malloc((wordSize + 1) * sizeof(char));
    char *titulo = NULL;
    char *name1, *name2;
    char linea[MAX_LINE_LENGTH];
    char letra;
    double similitud = 0.0;
    double distancia = 0.0;
    double min = 1.0;
    double duracion;
    int indexSecuencia = 0;
    int numEtiquetas = 0;
    int sumaTotalFrecuencias = 0;
    int i, j, z;
    int omitirHastaMas = 1;
	unsigned int max_capacity = pow(4, wordSize);

    // Inicializar la estructura de etiquetas para la secuencia inversa
    struct Etiqueta* etiquetas = malloc(MAX_DIRECTORIOS * sizeof(struct Etiqueta));
    if (etiquetas == NULL) {
        fprintf(stderr, "Error: No se pudo asignar memoria.\n");
        exit(1);
    }

    inicio = clock();

    archivoIN = fopen(fileName, "r");
    if (archivoIN == NULL) {
        fprintf(stderr, "No se pudo abrir el archivo.\n");
        free(secuencia);
        exit(1);
    }
    
    fseek(archivoIN, 0, SEEK_END);
    long fileSize = ftell(archivoIN);
    long pos;
    
    // Inicializar la primera etiqueta
    etiquetas[numEtiquetas].num_directorio = malloc(numDirectorios * sizeof(int));
    for (i = 0; i < numDirectorios; i++) {
        etiquetas[numEtiquetas].num_directorio[i] = 0;
    }
    etiquetas[numEtiquetas].num_palabras = 0;
    etiquetas[numEtiquetas].distancia_min = 1.0;
    etiquetas[numEtiquetas].directorio_min = malloc(numDirectorios * sizeof(int));
    etiquetas[numEtiquetas].num_directorios_min = 0;
    
    z = numEtiquetas_1 - 1;

    // Recorrer el archivo FASTQ
    for (pos = fileSize - 1; pos >= 0; pos--) {
        fseek(archivoIN, pos, SEEK_SET);
        letra = fgetc(archivoIN);
        
        // Omitir las líneas
        if (omitirHastaMas) {
            if (letra == '+') {
                omitirHastaMas = 0;
            }
            continue;
        }

        // Leer el título
        if (letra == '@') {
            fseek(archivoIN, pos, SEEK_SET);
            titulo = malloc(MAX_LINE_LENGTH * sizeof(char));
            if (titulo == NULL) {
                fprintf(stderr, "Error: No se pudo asignar memoria para el t�tulo.\n");
                fclose(archivoIN);
                free(secuencia);
                exit(1);
            }

            // Invertir el título
            int indexTitulo = 0;
            while ((letra = fgetc(archivoIN)) != '\n' && letra != EOF && indexTitulo < MAX_LINE_LENGTH - 1) {
                titulo[indexTitulo++] = letra;
            }
            titulo[indexTitulo] = '\0';
            
        	omitirHastaMas = 1;
        	
            // Inicializar la siguiente etiqueta
        	etiquetas[numEtiquetas].titulo = strdup(titulo);
        	numEtiquetas++;
        	z--;
        	
	        etiquetas[numEtiquetas].num_directorio = malloc(numDirectorios * sizeof(int));
	        for (i = 0; i < numDirectorios; i++) {
	            etiquetas[numEtiquetas].num_directorio[i] = 0;
	        }
	        etiquetas[numEtiquetas].num_palabras = 0;
	        etiquetas[numEtiquetas].distancia_min = 1.0;
	        etiquetas[numEtiquetas].directorio_min = malloc(numDirectorios * sizeof(int));
	        etiquetas[numEtiquetas].num_directorios_min = 0;
		} 
		else {
			if (letra == '\n' || letra == '\0') continue;
			
            // Procesar la secuencia
			if (etiquetas[numEtiquetas].num_palabras < etiquetas_1[z].num_palabras) {
			    if (indexSecuencia < wordSize) {
			        secuencia[indexSecuencia++] = letra;
			        if (indexSecuencia == wordSize) {
			            unsigned int indice = secuenciaAIndiceInverso(secuencia, wordSize);
			            if (indice != -1) {
			                for (i = 0; i < numDirectorios; i++) {
			                    if (directorios[i].nucleotidos[indice].frecuencia != 0) {
			                        etiquetas[numEtiquetas].num_directorio[i]++;   
			                    }
			                }
			                etiquetas[numEtiquetas].num_palabras++;
			        	}
			            memmove(secuencia, secuencia + 1, wordSize - 1);
			        	indexSecuencia = wordSize - 1;
			        }
				}
		    } else {
		    	indexSecuencia = 0;
			}
		}
    }
    fclose(archivoIN);
    
    
    // Calcular las distancias mínimas
    for (i = 0; i < numEtiquetas; i++) {
        // Eliminar el primer carácter del título '@'
    	if (etiquetas[i].titulo != NULL && strlen(etiquetas[i].titulo) > 0) {
        	memmove(etiquetas[i].titulo, etiquetas[i].titulo + 1, strlen(etiquetas[i].titulo));
    	}
        for (j = 0; j < numDirectorios; j++) {
            similitud = (double)etiquetas[i].num_directorio[j] / etiquetas[i].num_palabras; // Similitud
            distancia = 1 - similitud; // Distancia
            if (min > distancia) {
                min = distancia;
                etiquetas[i].directorio_min[0] = j;
                etiquetas[i].num_directorios_min = 1;
            } else if (min == distancia) {
                etiquetas[i].directorio_min[etiquetas[i].num_directorios_min] = j;
                etiquetas[i].num_directorios_min++;
            }
        }
        etiquetas[i].distancia_min = min; // Asigna la distancia mínima
        min = 1.0;
    }
    
    // Invertir las etiquetas
    invertirEtiquetas(etiquetas, numEtiquetas);

    fin = clock();

    duracion = (double)(fin - inicio) / CLOCKS_PER_SEC;
    
    for (i = 0; i < numEtiquetas; i++) {
        sumaTotalFrecuencias += etiquetas[i].num_palabras;
    }
    
    if (duracion > 1) {
    	*procesamientosPorSegundo = (double)sumaTotalFrecuencias / duracion;
	} else {
	    *procesamientosPorSegundo = (double)sumaTotalFrecuencias;
	}

    // Generar el nombre del archivo de salida
    *nombreArchivoSalida = malloc(strlen("Inversa_") + strlen(outputName1) + strlen(outputName2) + 1);
    if (*nombreArchivoSalida == NULL) {
        fprintf(stderr, "Error: No se pudo asignar memoria para el nombre del archivo de salida.\n");
        exit(1);
    }
    sprintf(*nombreArchivoSalida, "Inversa_%s_%s", outputName1, outputName2);

    imprimirFichero(*nombreArchivoSalida, etiquetas, directorios, numEtiquetas, numDirectorios, umbral, mayorMenor);
    graficaPorBarrasGnuplot(etiquetas, directorios, numEtiquetas, numDirectorios, *nombreArchivoSalida, outputName1);
    
    free(secuencia);
    free(titulo);
    
    return etiquetas;
}

/**
 * @brief Procesa un archivo FASTQ y genera una estructura de etiquetas.
 * 
 * Esta función toma un archivo FASTQ y genera una estructura de etiquetas con las distancias
 * de cada etiqueta a los directorios generados previamente.
 *  
 * @param fileName Nombre del archivo FASTQ.
 * @param outputName1 Nombre del primer archivo de salida.
 * @param outputName2 Nombre del segundo archivo de salida.
 * @param wordSize Tamaño de la palabra.
 * @param nombreArchivoSalida Puntero a un puntero de char donde se almacenará el nombre del archivo de salida.
 * @param directorios Puntero a la estructura de directorios.
 * @param numDirectorios Número de directorios.
 * @param numEtiqueta Puntero a un entero donde se almacenará el número de etiquetas.
 * @param umbral Umbral para el procesamiento.
 * @param mayorMenor Indicador de mayor o menor.
 * @param procesamientosPorSegundo Puntero a un double donde se almacenará el número de procesamientos por segundo.
 * 
 * @return struct Etiqueta* Puntero a la estructura de etiquetas generada.
 */
struct Etiqueta* procesarFastq(const char *fileName, const char *outputName1, const char *outputName2, int wordSize, char **nombreArchivoSalida, const struct Directorio *directorios, int numDirectorios, int *numEtiqueta, float umbral, int mayorMenor, double *procesamientosPorSegundo) {
    FILE *archivoIN;
    clock_t inicio, fin;
    char *secuencia = malloc((wordSize + 1) * sizeof(char));
    char *titulo = NULL;
    char *name1, *name2;
    char letra;
    double similitud = 0.0;
    double distancia = 0.0;
    double min = 1.0;
    double duracion;
    int numEtiquetas = 0;
    int indexSecuencia = 0;
    int longitudTitulo = 0;
    int directorio = 0;
    int sumaTotalFrecuencias = 0;
    int i, j, z;
    int ok = 0;
    unsigned int max_capacity = pow(4, wordSize);

    // Inicializar la estructura de etiquetas para la secuencia directa
    struct Etiqueta* etiquetas = malloc(MAX_DIRECTORIOS * sizeof(struct Etiqueta));
    if (etiquetas == NULL) {
        fprintf(stderr, "Error: No se pudo asignar memoria.\n");
        exit(1);
    }

    inicio = clock();

    archivoIN = fopen(fileName, "r");
    if (archivoIN == NULL) {
        fprintf(stderr, "No se pudo abrir el archivo.\n");
        free(secuencia);
        exit(1);
    }

    // Recorrer el archivo FASTQ
    while ((letra = fgetc(archivoIN)) != EOF) {	
        longitudTitulo = 0;
        titulo = NULL;

        // Leer el título
        while ((letra != '\n') && (letra != EOF)) {
            longitudTitulo++;
            titulo = (char *)realloc(titulo, longitudTitulo * sizeof(char));
            titulo[longitudTitulo - 1] = letra;
            letra = fgetc(archivoIN);
        }
        titulo = (char *)realloc(titulo, (longitudTitulo + 1) * sizeof(char));
        titulo[longitudTitulo] = '\0';
        
        // Inicializar la etiqueta
        etiquetas[numEtiquetas].titulo = strdup(titulo);
        etiquetas[numEtiquetas].num_directorio = malloc(numDirectorios * sizeof(int));
        for (i = 0; i < numDirectorios; i++) {
            etiquetas[numEtiquetas].num_directorio[i] = 0;
        }
        etiquetas[numEtiquetas].num_palabras = 0;
        etiquetas[numEtiquetas].distancia_min = 1.0;
        etiquetas[numEtiquetas].directorio_min = malloc(numDirectorios * sizeof(int));
        etiquetas[numEtiquetas].num_directorios_min = 0;

        // Procesar la secuencia
        indexSecuencia = 0;
        while ((letra = fgetc(archivoIN)) != '@' && letra != EOF) {
        	if (letra == '\n' || letra == '\0' || letra == 'N') continue;
			if (letra == '+' || ok == 1) {
            	ok = 1;
	    		continue;
			}

            if (indexSecuencia < wordSize) {
                secuencia[indexSecuencia++] = letra;
                if (indexSecuencia == wordSize) {
                    unsigned int indice = secuenciaAIndice(secuencia, wordSize);
                    for (i = 0; i < numDirectorios; i++) {
                        if (directorios[i].nucleotidos[indice].frecuencia != 0) {
                            etiquetas[numEtiquetas].num_directorio[i]++;   
                        }
                    }
                    etiquetas[numEtiquetas].num_palabras++; 
                }
            } else {
                memmove(secuencia, secuencia + 1, wordSize - 1);
                secuencia[wordSize - 1] = letra;
                secuencia[indexSecuencia] = '\0';
                unsigned int indice = secuenciaAIndice(secuencia, wordSize);
                for (i = 0; i < numDirectorios; i++) {
                    if (directorios[i].nucleotidos[indice].frecuencia != 0) {
                        etiquetas[numEtiquetas].num_directorio[i]++;   
                    }
                }
                etiquetas[numEtiquetas].num_palabras++;
            }
        }
        
        ok = 0;
        numEtiquetas++;
        (*numEtiqueta)++;
    }
    fclose(archivoIN);
    
    // Eliminar el primer carácter del título '@'
    if (etiquetas[0].titulo != NULL && strlen(etiquetas[0].titulo) > 0) {
        memmove(etiquetas[0].titulo, etiquetas[0].titulo + 1, strlen(etiquetas[0].titulo));
    }
    
    // Calcular las distancias mínimas
    for (i = 0; i < numEtiquetas; i++) {
        for (j = 0; j < numDirectorios; j++) {
            similitud = (double)etiquetas[i].num_directorio[j] / etiquetas[i].num_palabras; // Similitud
            distancia = 1 - similitud; // Distancia
            if (min > distancia) {
                min = distancia;
                etiquetas[i].directorio_min[0] = j;
                etiquetas[i].num_directorios_min = 1;
            } else if (min == distancia) {
                etiquetas[i].directorio_min[etiquetas[i].num_directorios_min] = j;
                etiquetas[i].num_directorios_min++;
            }
        }
        etiquetas[i].distancia_min = min; // Asigna la distancia mínima
        min = 1.0;
    }

    fin = clock();

    duracion = (double)(fin - inicio) / CLOCKS_PER_SEC;
    
    for (i = 0; i < numEtiquetas; i++) {
        sumaTotalFrecuencias += etiquetas[i].num_palabras;
    }
    
    if (duracion > 1) {
    	*procesamientosPorSegundo = (double)sumaTotalFrecuencias / duracion;
	} else {
	    *procesamientosPorSegundo = (double)sumaTotalFrecuencias;
	}

    // Generar el nombre del archivo de salida
    *nombreArchivoSalida = malloc(strlen("Tabla_") + strlen(outputName1) + strlen(outputName2) + 1);
    if (*nombreArchivoSalida == NULL) {
        fprintf(stderr, "Error: No se pudo asignar memoria para el nombre del archivo de salida.\n");
        exit(1);
    }
    sprintf(*nombreArchivoSalida, "Tabla_%s_%s", outputName1, outputName2);

    imprimirFichero(*nombreArchivoSalida, etiquetas, directorios, numEtiquetas, numDirectorios, umbral, mayorMenor);
    graficaPorBarrasGnuplot(etiquetas, directorios, numEtiquetas, numDirectorios, *nombreArchivoSalida, outputName1);
    
    free(secuencia);
    free(titulo);

    return etiquetas;
}

/**
 * @brief Procesa un archivo multifasta y genera una estructura de directorios.
 * 
 * Lee el archivo MULTIFASTA y separa por secuencias, que a su vez separa la secuencia en fragmentos de un tamaño dado.
 * Crea una estructura de directorios de secuencias que contiene cada uno de estos fragmentos con la frecuencia 
 * de aparición de los nucleótidos.
 * 
 * @param fileName Nombre del archivo multifasta a procesar.
 * @param wordSize Tamaño de la palabra (número de nucleótidos por fragmento).
 * @param numDirectorios Puntero a un entero donde se almacenará el número de directorios creados.
 * @param procesamientosPorSegundo Puntero a un double donde se almacenará el número de procesamientos por segundo.
 * 
 * @return struct Directorio* Puntero a la estructura de directorios generada, o NULL si ocurre un error.
 */
struct Directorio* procesarMultifasta(const char *fileName, int wordSize, int *numDirectorios, double *procesamientosPorSegundo) {
    FILE *archivoIN;
    clock_t inicio, fin;
    char *secuencia = malloc((wordSize + 1) * sizeof(char));
    char *titulo = NULL;
    char letra;
    double duracion;
    int indexSecuencia = 0;
    int longitudTitulo = 0;
    long sumaTotalFrecuencias = 0;
    int num = 0;
    int i, j;
    unsigned int max_capacity = pow(4, wordSize);

    // Inicializar la estructura de directorios
    struct Directorio *directorios = malloc(MAX_DIRECTORIOS * sizeof(struct Directorio));
    if (directorios == NULL) {
        fprintf(stderr, "Error: No se pudo asignar memoria.\n");
        free(secuencia);
        exit(1);
    }

    inicio = clock();

    archivoIN = fopen(fileName, "r");
    if (archivoIN == NULL) {
        fprintf(stderr, "No se pudo abrir el archivo.\n");
        free(secuencia);
        free(directorios);
        return NULL;
    }

    // Leer el archivo MULTIFASTA
    while ((letra = fgetc(archivoIN)) != EOF) {
        longitudTitulo = 0;
        titulo = NULL;

        // Leer el título
        while ((letra != '\n') && (letra != EOF)) {
            longitudTitulo++;
            titulo = (char *)realloc(titulo, longitudTitulo * sizeof(char));
            titulo[longitudTitulo - 1] = letra;
            letra = fgetc(archivoIN);
        }
        titulo = (char *)realloc(titulo, (longitudTitulo + 1) * sizeof(char));
        titulo[longitudTitulo] = '\0';
        
        // Inicializar el directorio
        directorios[num].titulo = strdup(titulo);
        directorios[num].nucleotidos = malloc(max_capacity * sizeof(struct Nucleotidos));
        
        // Inicializar los nucleótidos
        for (i = 0; i < max_capacity; i++) {
            directorios[num].nucleotidos[i].nucleotido = malloc((wordSize + 1) * sizeof(char));
            directorios[num].nucleotidos[i].frecuencia = 0;
        }

        // Procesar la secuencia
        indexSecuencia = 0;
        while ((letra = fgetc(archivoIN)) != '>' && letra != EOF) {
            if (letra == '\n' || letra == '\0') continue;
            if (letra == 'N') {
                indexSecuencia = 0;
                memset(secuencia, 0, (wordSize + 1) * sizeof(char));
                continue;
            }

            if (indexSecuencia < wordSize) {
                secuencia[indexSecuencia++] = letra;
                if (indexSecuencia == wordSize) {
                    procesarSecuencia(secuencia, directorios[num].nucleotidos, wordSize, max_capacity);
                }
            } else {
                memmove(secuencia, secuencia + 1, wordSize - 1);
                secuencia[wordSize - 1] = letra;
                procesarSecuencia(secuencia, directorios[num].nucleotidos, wordSize, max_capacity);
            }
        }
        
        num++;
        (*numDirectorios)++;
    }

    fclose(archivoIN);

    fin = clock();

    duracion = (double)(fin - inicio) / CLOCKS_PER_SEC;
    
    for (i = 0; i < *numDirectorios; i++) {
        for (j = 0; j < max_capacity; j++) {
            sumaTotalFrecuencias += directorios[i].nucleotidos[j].frecuencia;
        }
    }
    
    if (duracion > 1) {
    	*procesamientosPorSegundo = (double)sumaTotalFrecuencias / duracion;
	} else {
	    *procesamientosPorSegundo = (double)sumaTotalFrecuencias;
	}
    
    // Eliminar el primer carácter del título '>'
    if (directorios[0].titulo != NULL && strlen(directorios[0].titulo) > 0) {
        memmove(directorios[0].titulo, directorios[0].titulo + 1, strlen(directorios[0].titulo));
    }
    
    free(secuencia);
    free(titulo);

    return directorios;
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
unsigned int secuenciaAIndiceInverso(const char *secuencia, int wordSize) {
    unsigned int indice = 0;
    int i;
    for (i = 0; i < wordSize; i++) {
        indice <<= 2;
        switch (secuencia[i]) {
            case 'T': // 00
                break;
            case 'G': // 01
                indice |= 1;
                break;
            case 'C': // 10
                indice |= 2;
                break;
            case 'A': // 11
                indice |= 3;
                break;
            default:
                return -1;
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
 * @brief Invierte el orden de las etiquetas en un arreglo.
 * 
 * @param etiquetas Puntero a la estructura de etiquetas.
 * @param numEtiquetas Número de etiquetas.
 */
void invertirEtiquetas(struct Etiqueta* etiquetas, int numEtiquetas) {
    int i;
    for (i = 0; i < numEtiquetas / 2; ++i) {
        struct Etiqueta temp = etiquetas[i];
        etiquetas[i] = etiquetas[numEtiquetas - i - 1];
        etiquetas[numEtiquetas - i - 1] = temp;
    }
}

/**
 * @brief Imprime las etiquetas y directorios en un archivo.
 * 
 * @param nombreArchivoSalida Nombre del archivo de salida.
 * @param etiquetas Puntero a la estructura de etiquetas.
 * @param directorios Puntero a la estructura de directorios.
 * @param numEtiquetas Número de etiquetas.
 * @param numDirectorios Número de directorios.
 * @param umbral Umbral de distancia para la comparación.
 * @param mayorMenor Si es 0, busca distancias menores al umbral; si es 1, busca distancias mayores al umbral.
 */
void imprimirFichero(const char *nombreArchivoSalida, const struct Etiqueta *etiquetas, const struct Directorio *directorios, int numEtiquetas, int numDirectorios, float umbral, int mayorMenor) {   
	char nombreArchivoSalida1[256];
	sprintf(nombreArchivoSalida1, "%s.txt", nombreArchivoSalida);
    FILE *archivoOUT = fopen(nombreArchivoSalida1, "w");
    int i, j;
    
    // Imprime las etiquetas y directorios con la distancia mínima al completo
    if (archivoOUT == NULL) {
        fprintf(stderr, "No se pudo abrir el archivo de salida.\n");
        exit(1);
    }
    if (etiquetas == NULL || directorios == NULL) {
    	fprintf(stderr, "Etiquetas o Directorios son NULL.\n");
    	exit(1);
	}

    fprintf(archivoOUT, "Etiquetas\tDirectorios\tDistancia\n");
    
    for (i = 0; i < numEtiquetas; i++) {
    	fprintf(archivoOUT, "%s\t", etiquetas[i].titulo);
    	for (j = 0; j < etiquetas[i].num_directorios_min; j++) {
    		fprintf(archivoOUT, "%s\t%f", directorios[etiquetas[i].directorio_min[j]].titulo, etiquetas[i].distancia_min);
    		if (j < etiquetas[i].num_directorios_min - 1){
    			fprintf(archivoOUT, "\t");
			}
    	}
    	fprintf(archivoOUT, "\n");
    }

    fclose(archivoOUT);
    
    // Imprime las etiquetas y directorios con la distancia mínima por encima o por debajo del umbral
    char ficheroUmbral[256];
	sprintf(ficheroUmbral, "%s_%.2f.txt", nombreArchivoSalida, umbral);
	FILE *archivoOUTUmbral = fopen(ficheroUmbral, "w");

	if (archivoOUTUmbral == NULL) {
	    fprintf(stderr, "No se pudo abrir el archivo de salida.\n");
	    exit(1);
	}
	if (etiquetas == NULL || directorios == NULL) {
	    fprintf(stderr, "Etiquetas o Directorios son NULL.\n");
	    exit(1);
	}
	
	fprintf(archivoOUTUmbral, "Etiquetas\tDirectorios\tDistancia\n");
	
    // Si mayorMenor es 1, busca distancias mayores al umbral; si es 0, busca distancias menores al umbral
	if (mayorMenor == 1) {
	    for (i = 0; i < numEtiquetas; i++) {
	        int seImprimeEtiqueta = 0;
	        for (j = 0; j < etiquetas[i].num_directorios_min; j++) {
	            if (etiquetas[i].distancia_min > umbral) {
	                if (!seImprimeEtiqueta) {
	                    fprintf(archivoOUTUmbral, "%s\t", etiquetas[i].titulo);
	                    seImprimeEtiqueta = 1;
	                }
	                fprintf(archivoOUTUmbral, "%s\t%f", directorios[etiquetas[i].directorio_min[j]].titulo, etiquetas[i].distancia_min);
	                if (j < etiquetas[i].num_directorios_min - 1) {
	                    fprintf(archivoOUTUmbral, "\t");
	                }
	            }
	        }
	        if (seImprimeEtiqueta) {
	            fprintf(archivoOUTUmbral, "\n");
	        }
	    }
	} else {
	    for (i = 0; i < numEtiquetas; i++) {
	        int seImprimeEtiqueta = 0;
	        for (j = 0; j < etiquetas[i].num_directorios_min; j++) {
	            if (etiquetas[i].distancia_min < umbral) {
	                if (!seImprimeEtiqueta) {
	                    fprintf(archivoOUTUmbral, "%s\t", etiquetas[i].titulo);
	                    seImprimeEtiqueta = 1;
	                }
	                fprintf(archivoOUTUmbral, "%s\t%f", directorios[etiquetas[i].directorio_min[j]].titulo, etiquetas[i].distancia_min);
	                if (j < etiquetas[i].num_directorios_min - 1) {
	                    fprintf(archivoOUTUmbral, "\t");
	                }
	            }
	        }
	        if (seImprimeEtiqueta) {
	            fprintf(archivoOUTUmbral, "\n");
	        }
	    }
	}
	
	fclose(archivoOUTUmbral);

}

/**
 * @brief Modifica los títulos de los archivos.
 * 
 * Extrae el nombre del archivo de un path y elimina la extensión.
 * 
 * @param input Puntero al nombre del archivo de entrada.
 * @param output Puntero a un puntero de char donde se almacenará el nombre del archivo de salida.
 */
void modicarTitulos(const char *input, char **output) {
    const char *lastSlash = strrchr(input, '/');
    const char *lastBackslash = strrchr(input, '\\');
    const char *lastSeparator = lastSlash > lastBackslash ? lastSlash : lastBackslash;

    if (lastSeparator != NULL) {
        input = lastSeparator + 1;
    }

    const char *lastDot = strrchr(input, '.');
    size_t length = 0;
    if (lastDot != NULL) {
        length = lastDot - input;
    } else {
        length = strlen(input);
    }

    *output = malloc((length + 1) * sizeof(char));
    if (*output == NULL) {
        printf("Failed to allocate memory for output.\n");
        return;
    }

    strncpy(*output, input, length);
    (*output)[length] = '\0';
}

/**
 * @brief Genera un script de Gnuplot para generar una gráfica de barras a partir de la frecuencia de aprición de los directorios en las etiquetas.
 * 
 * @param etiquetas Puntero a la estructura de etiquetas.
 * @param directorios Puntero a la estructura de directorios.
 * @param numEtiquetas Número de etiquetas.
 * @param numDirectorios Número de directorios.
 * @param nombreArchivoSalida Nombre del archivo de salida.
 * @param outputName1 Nombre del primer archivo de salida.
 */
void graficaPorBarrasGnuplot(const struct Etiqueta *etiquetas, const struct Directorio *directorios, int numEtiquetas, int numDirectorios, const char *nombreArchivoSalida, const char *outputName1) {
	FILE *gnuplotScript, *archivoDatos;
	int max = 0;
	int i, j, z;
	int *directorios_frecuencia = malloc(numDirectorios * sizeof(int));
    for (i = 0; i < numDirectorios; i++) {
        directorios_frecuencia[i] = 0;
    }
    
    archivoDatos = fopen("datos_para_graficar.txt", "w");
    if (archivoDatos == NULL) {
        fprintf(stderr, "No se pudo abrir el archivo de graficas\n");
        exit(1);
    }
    
    // Guarda las freceuncia de aparicion de los directorios en la etiquetas
    for (i = 0; i < numDirectorios; i++) {
        for (j = 0; j < numEtiquetas; j++) {
            for (z = 0; z < etiquetas[j].num_directorios_min; z++) {
                if (i == etiquetas[j].directorio_min[z]) {
                    directorios_frecuencia[i]++;
                }
            }
            if (max < directorios_frecuencia[i]) {
            	max = directorios_frecuencia[i];
			}
        }
        fprintf(archivoDatos, "%d\t%d\n", i+1, directorios_frecuencia[i]);
    }
    
    fclose(archivoDatos);
    
    // Ajusta el rango de la grafica
    max = max + max / 10;
    
    // Genera el script de Gnuplot
    gnuplotScript = fopen("script_gnuplot.gp", "w");
    if (gnuplotScript == NULL) {
        fprintf(stderr, "No se pudo abrir el archivo del script de Gnuplot\n");
        exit(1);
    }
    
    fprintf(gnuplotScript, "set terminal png size 1280,720\n");
    fprintf(gnuplotScript, "set output '%s.png'\n", nombreArchivoSalida);
    fprintf(gnuplotScript, "set title '%s'\n", nombreArchivoSalida);
    fprintf(gnuplotScript, "set xlabel '%s'\n", outputName1);
    fprintf(gnuplotScript, "set ylabel 'Frecuencia'\n");
    fprintf(gnuplotScript, "set xrange [-1:%d]\n", numDirectorios);
    fprintf(gnuplotScript, "set yrange [0:%d]\n", max);
    fprintf(gnuplotScript, "set mytics 5\n");
    fprintf(gnuplotScript, "set boxwidth 0.9\n");
    fprintf(gnuplotScript, "set style fill solid 0.5\n");
    fprintf(gnuplotScript, "set datafile separator '\t'\n");
    fprintf(gnuplotScript, "plot 'datos_para_graficar.txt' using 2:xtic(1) with boxes notitle\n");
    fclose(gnuplotScript);

    int result = system("gnuplot script_gnuplot.gp");
    if (result != 0) {
        fprintf(stderr, "Error al ejecutar Gnuplot\n");
        exit(1);
    }
    
    free(directorios_frecuencia);
}

