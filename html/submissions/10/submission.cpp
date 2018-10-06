#include<cstdio>
#include<cstring>
#include<cmath>
int p[101], f[21], a[21], n;
long cnt=0;

void sieve(int nmax)
{
    memset(p, 1, sizeof(p));
    p[1]=p[0]=0;
    int i, j, lim=sqrt(nmax);
    for (i=2; i<=lim; ++i)
        if (p[i])   for (j=2; j<=nmax/i; ++j) p[i*j]=0;
}

void print()
{
    for (int i=1; i<=2*n; ++i) printf("%d ", a[i]);
    printf("\n");
    ++cnt;
}

void construct(int i)
{
    for (int j=1; j<=2*n; ++j)
        if (!f[j]&&p[j+a[i-1]])
        {
            f[j]=1;
            a[i]=j;
            if (i==2*n&&p[j+1]) print();
            else construct(i+1);
            f[j]=0;
            a[i]=0;
        }
}

int main()
{

    scanf("%d", &n);
    sieve(100);
    memset(a, 0, sizeof(a));
    memset(f, 0, sizeof(f));
    f[1]=1;
    a[1]=1;
    construct(2);
    printf("%ld", cnt);

    return 0;
}
