#include<cstdio>
#include<cstring>

long f[100];

int main()
{
    memset(f, 0, sizeof(f));
    f[0]=f[1]=1;
    for (int i=2; i<=90; ++i) f[i]=f[i-1]+f[i-2];
    int n;
    scanf("%d", &n);
    printf("%ld", f[n/2]);
    return 0;
}
