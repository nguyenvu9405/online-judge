#include<cstdio>
#include<cstring>

int a[30], f[2], n;
long cnt;

void print()
{
    for (int i=0; i<n; ++i) printf("%c", a[i]+'(');
    printf("\n");
}

void construct(int i)
{
    for (int j=0; j<=1; ++j)
    {
        if (f[0]==f[1]&&j) continue;
        if (f[j]==n/2) continue;
        a[i]=j;
        ++f[j];
        if (i<n-1) construct(i+1);
        else
        {
            ++cnt;
            //print();
        }
        --f[j];
    }
}

int main()
{
    memset(f, 0, sizeof(f));
    memset(a, 0, sizeof(a));
    scanf("%d", &n);
    construct(0);
    printf("%ld", cnt);
    return 0;
}
